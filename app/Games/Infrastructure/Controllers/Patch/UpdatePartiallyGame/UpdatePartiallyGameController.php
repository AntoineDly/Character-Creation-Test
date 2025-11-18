<?php

declare(strict_types=1);

namespace App\Games\Infrastructure\Controllers\Patch\UpdatePartiallyGame;

use App\Games\Application\Commands\UpdatePartiallyGameCommand\UpdatePartiallyGameCommand;
use App\Shared\Application\Commands\CommandBus;
use App\Shared\Infrastructure\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Infrastructure\Http\Exceptions\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class UpdatePartiallyGameController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private CommandBus $commandBus,
    ) {
    }

    public function __invoke(UpdatePartiallyGameRequest $request, string $id): JsonResponse
    {
        try {
            /** @var array{'name': ?string, 'visibleForAll': ?bool} $validated */
            $validated = $request->validated();

            $command = new UpdatePartiallyGameCommand(
                id: $id,
                name: $validated['name'] ?? null,
                visibleForAll: $validated['visibleForAll'] ?? null,
            );

            $this->commandBus->dispatch($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Game was not successfully updated partially.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'Game was successfully updated partially.');
    }
}
