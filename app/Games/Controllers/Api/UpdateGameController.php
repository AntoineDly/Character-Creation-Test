<?php

declare(strict_types=1);

namespace App\Games\Controllers\Api;

use App\Games\Commands\UpdateGameCommand;
use App\Games\Commands\UpdatePartiallyGameCommand;
use App\Games\Requests\UpdateGameRequest;
use App\Games\Requests\UpdatePartiallyGameRequest;
use App\Shared\CommandBus\CommandBus;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Http\Exceptions\HttpExceptionInterface;
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
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Game was not successfully updated.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Game was successfully updated.');
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
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Game was not successfully updated partially.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Game was successfully updated partially.');
    }
}
