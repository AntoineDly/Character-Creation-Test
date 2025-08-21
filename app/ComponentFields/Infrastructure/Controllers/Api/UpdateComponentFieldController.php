<?php

declare(strict_types=1);

namespace App\ComponentFields\Infrastructure\Controllers\Api;

use App\ComponentFields\Application\Commands\UpdateComponentFieldCommand\UpdateComponentFieldCommand;
use App\ComponentFields\Application\Commands\UpdatePartiallyComponentFieldCommand\UpdatePartiallyComponentFieldCommand;
use App\ComponentFields\Infrastructure\Requests\UpdateComponentFieldRequest;
use App\ComponentFields\Infrastructure\Requests\UpdatePartiallyComponentFieldRequest;
use App\Helpers\ArrayHelper;
use App\Shared\CommandBus\CommandBus;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Http\Exceptions\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class UpdateComponentFieldController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private CommandBus $commandBus,
    ) {
    }

    public function updateComponentField(UpdateComponentFieldRequest $request, string $id): JsonResponse
    {
        try {
            /** @var array{'value': string, 'componentId': string, 'parameterId': string} $validated */
            $validated = $request->validated();

            $command = new UpdateComponentFieldCommand(
                id: $id,
                value: $validated['value'],
                componentId: $validated['componentId'],
                parameterId: $validated['parameterId'],
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Component was not successfully updated.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'ComponentField was successfully updated.');
    }

    public function updatePartiallyComponentField(UpdatePartiallyComponentFieldRequest $request, string $id): JsonResponse
    {
        try {
            /** @var array{'value': ?string, 'componentId': ?string, 'parameterId': ?string} $validated */
            $validated = $request->validated();

            $command = new UpdatePartiallyComponentFieldCommand(
                id: $id,
                value: ArrayHelper::returnNullOrStringValueOfKey(array: $validated, key: 'value'),
                componentId: ArrayHelper::returnNullOrStringValueOfKey(array: $validated, key: 'componentId'),
                parameterId: ArrayHelper::returnNullOrStringValueOfKey(array: $validated, key: 'parameterId'),
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Component was not successfully updated partially.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'ComponentField was successfully updated partially.');
    }
}
