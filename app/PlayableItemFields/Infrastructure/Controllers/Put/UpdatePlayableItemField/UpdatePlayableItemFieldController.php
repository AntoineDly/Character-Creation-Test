<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Infrastructure\Controllers\Put\UpdatePlayableItemField;

use App\PlayableItemFields\Application\Commands\UpdatePlayableItemFieldCommand\UpdatePlayableItemFieldCommand;
use App\Shared\Application\Commands\CommandBus;
use App\Shared\Infrastructure\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Infrastructure\Http\Exceptions\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class UpdatePlayableItemFieldController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private CommandBus $commandBus,
    ) {
    }

    public function __invoke(UpdatePlayableItemFieldRequest $request, string $id): JsonResponse
    {
        try {
            /** @var array{'value': string, 'playableItemId': string, 'parameterId': string} $validated */
            $validated = $request->validated();

            $command = new UpdatePlayableItemFieldCommand(
                id: $id,
                value: $validated['value'],
                playableItemId: $validated['playableItemId'],
                parameterId: $validated['parameterId'],
            );

            $this->commandBus->dispatch($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'PlayableItem Field was not successfully updated.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'PlayableItem Field was successfully updated.');
    }
}
