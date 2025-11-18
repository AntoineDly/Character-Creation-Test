<?php

declare(strict_types=1);

namespace App\Games\Infrastructure\Controllers\Put\UpdateGame;

use App\Games\Application\Commands\UpdateGameCommand\UpdateGameCommand;
use App\Shared\Application\Commands\CommandBus;
use App\Shared\Infrastructure\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Infrastructure\Http\Exceptions\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class UpdateGameController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private CommandBus $commandBus,
    ) {
    }

    public function __invoke(UpdateGameRequest $request, string $id): JsonResponse
    {
        try {
            /** @var array{'name': string, 'visibleForAll': bool} $validated */
            $validated = $request->validated();

            $command = new UpdateGameCommand(
                id: $id,
                name: $validated['name'],
                visibleForAll: $validated['visibleForAll'],
            );

            $this->commandBus->dispatch($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Game was not successfully updated.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'Game was successfully updated.');
    }
}
