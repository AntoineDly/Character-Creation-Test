<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Infrastructure\Controllers\Patch\UpdatePartiallyLinkedItemField;

use App\Helpers\ArrayHelper;
use App\LinkedItemFields\Application\Commands\UpdatePartiallyLinkedItemFieldCommand\UpdatePartiallyLinkedItemFieldCommand;
use App\Shared\Application\Commands\CommandBus;
use App\Shared\Infrastructure\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Infrastructure\Http\Exceptions\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class UpdatePartiallyLinkedItemFieldController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private CommandBus $commandBus,
    ) {
    }

    public function __invoke(UpdatePartiallyLinkedItemFieldRequest $request, string $id): JsonResponse
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
                message: 'LinkedItem Field was not successfully updated partially.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'LinkedItem Field was successfully updated partially.');
    }
}
