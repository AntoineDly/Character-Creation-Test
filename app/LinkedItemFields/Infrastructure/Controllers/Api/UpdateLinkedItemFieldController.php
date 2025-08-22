<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Infrastructure\Controllers\Api;

use App\Helpers\ArrayHelper;
use App\LinkedItemFields\Application\Commands\UpdateLinkedItemFieldCommand\UpdateLinkedItemFieldCommand;
use App\LinkedItemFields\Application\Commands\UpdatePartiallyLinkedItemFieldCommand\UpdatePartiallyLinkedItemFieldCommand;
use App\LinkedItemFields\Infrastructure\Requests\UpdateLinkedItemFieldRequest;
use App\LinkedItemFields\Infrastructure\Requests\UpdatePartiallyLinkedItemFieldRequest;
use App\Shared\Commands\CommandBus;
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

            $this->commandBus->dispatch($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Linked ItemField was not successfully updated.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'Linked ItemField was successfully updated.');
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

            $this->commandBus->dispatch($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Linked ItemField was not successfully updated partially.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'Linked ItemField was successfully updated partially.');
    }
}
