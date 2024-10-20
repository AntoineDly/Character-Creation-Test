<?php

declare(strict_types=1);

namespace App\Games\Controllers\Api;

use App\Games\Commands\UpdateGameCommand;
use App\Games\Commands\UpdatePartiallyGameCommand;
use App\Games\Requests\UpdateGameRequest;
use App\Games\Requests\UpdatePartiallyGameRequest;
use App\Shared\CommandBus\CommandBus;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

final readonly class UpdateGameController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private CommandBus $commandBus,
    ) {
    }

    public function updateGame(UpdateGameRequest $request, string $id): JsonResponse
    {
        try {
            /** @var array{'name': string, 'visibleForAll': bool} $validated */
            $validated = $request->validated();

            $command = new UpdateGameCommand(
                id: $id,
                name: $validated['name'],
                visibleForAll: $validated['visibleForAll'],
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendError(error: 'Game was not successfully updated', errorContent: $e->errors());
        } catch (Exception $e) {
            return $this->apiController->sendException(exception: $e);
        }

        return $this->apiController->sendSuccess(message: 'Game was successfully updated');
    }

    public function updatePartiallyGame(UpdatePartiallyGameRequest $request, string $id): JsonResponse
    {
        try {
            /** @var array{'name': ?string, 'visibleForAll': ?bool} $validated */
            $validated = $request->validated();

            $command = new UpdatePartiallyGameCommand(
                id: $id,
                name: $validated['name'] ?? null,
                visibleForAll: $validated['visibleForAll'] ?? null,
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendError(error: 'Game was not successfully updated partially', errorContent: $e->errors());
        } catch (Exception $e) {
            return $this->apiController->sendException(exception: $e);
        }

        return $this->apiController->sendSuccess(message: 'Game was successfully updated partially');
    }
}
