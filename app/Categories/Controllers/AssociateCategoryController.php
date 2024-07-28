<?php

declare(strict_types=1);

namespace App\Categories\Controllers;

use App\Base\CommandBus\CommandBus;
use App\Base\Controllers\ApiController\ApiControllerInterface;
use App\Categories\Commands\AssociateCategoryGameCommand;
use App\Categories\Requests\AssociateCategoryGameRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

final class AssociateCategoryController
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
            return $this->apiController->sendError(error: 'Game was not successfully associated to the category', errorContent: $e->errors());
        }

        return $this->apiController->sendSuccess(message: 'Game was successfully created to the category');
    }
}
