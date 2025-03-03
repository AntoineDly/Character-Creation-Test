<?php

declare(strict_types=1);

namespace App\ItemFields\Controllers\Api;

use App\Helpers\ArrayHelper;
use App\ItemFields\Commands\UpdateItemFieldCommand;
use App\ItemFields\Commands\UpdatePartiallyItemFieldCommand;
use App\ItemFields\Requests\UpdateItemFieldRequest;
use App\ItemFields\Requests\UpdatePartiallyItemFieldRequest;
use App\Shared\CommandBus\CommandBus;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Exceptions\Http\HttpExceptionInterface;
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

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Item Field was not successfully updated.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Item Field was successfully updated.');
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

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Item Field was not successfully updated partially.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Item Field was successfully updated partially.');
    }
}
