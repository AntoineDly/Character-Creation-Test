<?php

declare(strict_types=1);

namespace App\PlayableItems\Infrastructure\Controllers\Api;

use App\Helpers\RequestHelper;
use App\PlayableItems\Application\Commands\CreatePlayableItemCommand\CreatePlayableItemCommand;
use App\PlayableItems\Infrastructure\Requests\CreatePlayableItemRequest;
use App\Shared\CommandBus\CommandBus;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Http\Exceptions\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class CreatePlayableItemController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private CommandBus $commandBus,
    ) {
    }

    public function createPlayableItem(CreatePlayableItemRequest $request): JsonResponse
    {
        try {
            /** @var array{'itemId': string, 'gameId': string} $validated */
            $validated = $request->validated();

            $command = new CreatePlayableItemCommand(
                itemId: $validated['itemId'],
                gameId: $validated['gameId'],
                userId: RequestHelper::getUserId($request),
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Playable Item was not successfully created.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendCreated(message: 'Playable Item was successfully created.');
    }
}
