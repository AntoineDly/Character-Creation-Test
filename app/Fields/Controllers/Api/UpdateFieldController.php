<?php

declare(strict_types=1);

namespace App\Fields\Controllers\Api;

use App\Fields\Commands\UpdateFieldCommand;
use App\Fields\Commands\UpdatePartiallyFieldCommand;
use App\Fields\Requests\UpdateFieldRequest;
use App\Fields\Requests\UpdatePartiallyFieldRequest;
use App\Helpers\ArrayHelper;
use App\Shared\CommandBus\CommandBus;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Exceptions\Http\HttpExceptionInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

final readonly class UpdateFieldController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private CommandBus $commandBus,
    ) {
    }

    public function updateField(UpdateFieldRequest $request, string $id): JsonResponse
    {
        try {
            /** @var array{'value': string, 'linkedItemId': string, 'parameterId': string} $validated */
            $validated = $request->validated();

            $command = new UpdateFieldCommand(
                id: $id,
                value: $validated['value'],
                linkedItemId: $validated['linkedItemId'],
                parameterId: $validated['parameterId']
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Field was not successfully updated.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException(exception: $e);
        } catch (Exception $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Field was successfully updated.');
    }

    public function updatePartiallyField(UpdatePartiallyFieldRequest $request, string $id): JsonResponse
    {
        try {
            /** @var array{'value': ?string, 'linkedItemId': ?string, 'parameterId': ?string} $validated */
            $validated = $request->validated();

            $command = new UpdatePartiallyFieldCommand(
                id: $id,
                value: ArrayHelper::returnNullOrStringValueOfKey(array: $validated, key: 'value'),
                linkedItemId: ArrayHelper::returnNullOrStringValueOfKey(array: $validated, key: 'linkedItemId'),
                parameterId: ArrayHelper::returnNullOrStringValueOfKey(array: $validated, key: 'parameterId')
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Field was not successfully updated partially.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException(exception: $e);
        } catch (Exception $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Field was successfully updated partially.');
    }
}
