<?php

declare(strict_types=1);

namespace App\Categories\Controllers\Api;

use App\Categories\Commands\AssociateCategoryGameCommand;
use App\Categories\Requests\AssociateCategoryGameRequest;
use App\Shared\CommandBus\CommandBus;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Enums\HttpStatusEnum;
use App\Shared\Exceptions\Http\HttpExceptionInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

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
                message: 'Game was not successfully associated to the category',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException(exception: $e);
        } catch (Exception $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Game was successfully associated to the category', status: HttpStatusEnum::CREATED);
    }
}