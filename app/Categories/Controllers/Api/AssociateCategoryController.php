<?php

declare(strict_types=1);

namespace App\Categories\Controllers\Api;

use App\Categories\Commands\AssociateCategoryGameCommand;
use App\Categories\Requests\AssociateCategoryGameRequest;
use App\Shared\CommandBus\CommandBus;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Http\Exceptions\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class AssociateCategoryController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private CommandBus $commandBus,
    ) {
    }

    public function associateGame(AssociateCategoryGameRequest $request): JsonResponse
    {
        try {
            /** @var array{'categoryId': string, 'gameId': string} $validated */
            $validated = $request->validated();

            $command = new AssociateCategoryGameCommand(
                categoryId: $validated['categoryId'],
                gameId: $validated['gameId'],
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Game was not successfully associated to the category.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendCreated(message: 'Game was successfully associated to the category.');
    }
}
