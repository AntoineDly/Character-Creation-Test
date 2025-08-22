<?php

declare(strict_types=1);

namespace App\ItemFields\Infrastructure\Controllers\Api;

use App\Helpers\ArrayHelper;
use App\ItemFields\Application\Commands\UpdateItemFieldCommand\UpdateItemFieldCommand;
use App\ItemFields\Application\Commands\UpdatePartiallyItemFieldCommand\UpdatePartiallyItemFieldCommand;
use App\ItemFields\Infrastructure\Requests\UpdateItemFieldRequest;
use App\ItemFields\Infrastructure\Requests\UpdatePartiallyItemFieldRequest;
use App\Shared\Commands\CommandBus;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Http\Exceptions\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class UpdateItemFieldController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private CommandBus $commandBus,
    ) {
    }

    public function updateItemField(UpdateItemFieldRequest $request, string $id): JsonResponse
    {
        try {
            /** @var array{'value': string, 'itemId': string, 'parameterId': string} $validated */
            $validated = $request->validated();

            $command = new UpdateItemFieldCommand(
                id: $id,
                value: $validated['value'],
                itemId: $validated['itemId'],
                parameterId: $validated['parameterId'],
            );

            $this->commandBus->dispatch($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'ItemField was not successfully updated.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'ItemField was successfully updated.');
    }

    public function updatePartiallyItemField(UpdatePartiallyItemFieldRequest $request, string $id): JsonResponse
    {
        try {
            /** @var array{'value': ?string, 'itemId': ?string, 'parameterId': ?string} $validated */
            $validated = $request->validated();

            $command = new UpdatePartiallyItemFieldCommand(
                id: $id,
                value: ArrayHelper::returnNullOrStringValueOfKey(array: $validated, key: 'value'),
                itemId: ArrayHelper::returnNullOrStringValueOfKey(array: $validated, key: 'itemId'),
                parameterId: ArrayHelper::returnNullOrStringValueOfKey(array: $validated, key: 'parameterId'),
            );

            $this->commandBus->dispatch($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'ItemField was not successfully updated partially.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'ItemField was successfully updated partially.');
    }
}
