<?php

declare(strict_types=1);

namespace App\CategoryGames\Infrastructure\Controllers;

use App\CategoryGames\Application\Commands\CreateCategoryGameCommand\CreateCategoryGameCommand;
use App\CategoryGames\Infrastructure\Requests\CreateCategoryGameRequest;
use App\Shared\Application\Commands\CommandBus;
use App\Shared\Infrastructure\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Infrastructure\Http\Exceptions\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class CreateCategoryGameController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private CommandBus $commandBus,
    ) {
    }

    public function createCategoryGame(CreateCategoryGameRequest $request): JsonResponse
    {
        try {
            /** @var array{'categoryId': string, 'gameId': string} $validated */
            $validated = $request->validated();

            $command = new CreateCategoryGameCommand(
                categoryId: $validated['categoryId'],
                gameId: $validated['gameId'],
            );

            $this->commandBus->dispatch($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'CategoryGame was not successfully created.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendCreated(message: 'CategoryGame was successfully created.');
    }
}
