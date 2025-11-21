<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Infrastructure\Controllers\Put\UpdateLinkedItemField;

use App\LinkedItemFields\Application\Commands\UpdateLinkedItemFieldCommand\UpdateLinkedItemFieldCommand;
use App\Shared\Application\Commands\CommandBus;
use App\Shared\Infrastructure\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Infrastructure\Http\Exceptions\HttpExceptionInterface;
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

    public function __invoke(UpdateLinkedItemFieldRequest $request, string $id): JsonResponse
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
                message: 'LinkedItem Field was not successfully updated.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'LinkedItem Field was successfully updated.');
    }
}
