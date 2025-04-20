<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Controllers\Api;

use App\Helpers\ArrayHelper;
use App\LinkedItemFields\Commands\UpdateLinkedItemFieldCommand;
use App\LinkedItemFields\Commands\UpdatePartiallyLinkedItemFieldCommand;
use App\LinkedItemFields\Requests\UpdateLinkedItemFieldRequest;
use App\LinkedItemFields\Requests\UpdatePartiallyLinkedItemFieldRequest;
use App\Shared\CommandBus\CommandBus;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Http\Exceptions\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class UpdateLinkedItemFieldController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private CommandBus $commandBus,
    ) {
    }

    public function updateLinkedItemField(UpdateLinkedItemFieldRequest $request, string $id): JsonResponse
    {
        try {
            /** @var array{'value': string, 'linkedItemId': string, 'parameterId': string} $validated */
            $validated = $request->validated();

            $command = new UpdateLinkedItemFieldCommand(
                id: $id,
                value: $validated['value'],
                linkedItemId: $validated['linkedItemId'],
                parameterId: $validated['parameterId']
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Linked Item Field was not successfully updated.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Linked Item Field was successfully updated.');
    }

    public function updatePartiallyLinkedItemField(UpdatePartiallyLinkedItemFieldRequest $request, string $id): JsonResponse
    {
        try {
            /** @var array{'value': ?string, 'linkedItemId': ?string, 'parameterId': ?string} $validated */
            $validated = $request->validated();

            $command = new UpdatePartiallyLinkedItemFieldCommand(
                id: $id,
                value: ArrayHelper::returnNullOrStringValueOfKey(array: $validated, key: 'value'),
                linkedItemId: ArrayHelper::returnNullOrStringValueOfKey(array: $validated, key: 'linkedItemId'),
                parameterId: ArrayHelper::returnNullOrStringValueOfKey(array: $validated, key: 'parameterId')
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Linked Item Field was not successfully updated partially.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Linked Item Field was successfully updated partially.');
    }
}
