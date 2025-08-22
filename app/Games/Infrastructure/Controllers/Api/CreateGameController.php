<?php

declare(strict_types=1);

namespace App\Games\Infrastructure\Controllers\Api;

use App\Games\Application\Commands\CreateGameCommand\CreateGameCommand;
use App\Games\Infrastructure\Requests\CreateGameRequest;
use App\Helpers\RequestHelper;
use App\Shared\Commands\CommandBus;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Http\Exceptions\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class CreateGameController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private CommandBus $commandBus,
    ) {
    }

    public function createGame(CreateGameRequest $request): JsonResponse
    {
        try {
            /** @var array{'name': string, 'visibleForAll': bool} $validated */
            $validated = $request->validated();

            $command = new CreateGameCommand(
                name: $validated['name'],
                visibleForAll: $validated['visibleForAll'],
                userId: RequestHelper::getUserId($request),
            );

            $this->commandBus->dispatch($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Game was not successfully created.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendCreated(message: 'Game was successfully created.');
    }
}
