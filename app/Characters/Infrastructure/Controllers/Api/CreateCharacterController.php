<?php

declare(strict_types=1);

namespace App\Characters\Infrastructure\Controllers\Api;

use App\Characters\Application\Commands\CreateCharacterCommand\CreateCharacterCommand;
use App\Characters\Infrastructure\Requests\CreateCharacterRequest;
use App\Helpers\RequestHelper;
use App\Shared\Application\Commands\CommandBus;
use App\Shared\Infrastructure\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Infrastructure\Http\Exceptions\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class CreateCharacterController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private CommandBus $commandBus,
    ) {
    }

    public function createCharacter(CreateCharacterRequest $request): JsonResponse
    {
        try {
            /** @var array{'gameId': string} $validated */
            $validated = $request->validated();

            $command = new CreateCharacterCommand(
                gameId: $validated['gameId'],
                userId: RequestHelper::getUserId($request),
            );

            $this->commandBus->dispatch($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Character was not successfully created.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendCreated(message: 'Character was successfully created.');
    }
}
