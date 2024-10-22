<?php

declare(strict_types=1);

namespace App\Games\Controllers\Api;

use App\Games\Commands\CreateGameCommand;
use App\Games\Requests\CreateGameRequest;
use App\Helpers\RequestHelper;
use App\Shared\CommandBus\CommandBus;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Exceptions\Http\HttpExceptionInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

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

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Game was not successfully created.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException(exception: $e);
        } catch (Exception $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Game was successfully created.');
    }
}
