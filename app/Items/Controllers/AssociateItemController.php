<?php

declare(strict_types=1);

namespace App\Items\Controllers;

use App\Base\CommandBus\CommandBus;
use App\Base\Controllers\ApiController\ApiControllerInterface;
use App\Items\Commands\AssociateItemCategoryCommand;
use App\Items\Commands\AssociateItemGameCommand;
use App\Items\Requests\AssociateItemCategoryRequest;
use App\Items\Requests\AssociateItemGameRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

final readonly class AssociateItemController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private CommandBus $commandBus,
    ) {
    }

    public function associateGame(AssociateItemGameRequest $request): JsonResponse
    {
        try {
            /** @var array{'itemId': string, 'gameId': string} $validated */
            $validated = $request->validated();

            $command = new AssociateItemGameCommand(
                itemId: $validated['itemId'],
                gameId: $validated['gameId'],
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendError(error: 'Game was not successfully associated to the item', errorContent: $e->errors());
        }

        return $this->apiController->sendSuccess(message: 'Game was successfully associated to the item');
    }

    public function associateCategory(AssociateItemCategoryRequest $request): JsonResponse
    {
        try {
            /** @var array{'itemId': string, 'categoryId': string} $validated */
            $validated = $request->validated();

            $command = new AssociateItemCategoryCommand(
                itemId: $validated['itemId'],
                categoryId: $validated['categoryId'],
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendError(error: 'Category was not successfully associated to the item', errorContent: $e->errors());
        }

        return $this->apiController->sendSuccess(message: 'Category was successfully associated to the item');
    }
}
