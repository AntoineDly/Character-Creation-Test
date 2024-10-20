<?php

declare(strict_types=1);

namespace App\Items\Controllers\Api;

use App\Helpers\RequestHelper;
use App\Items\Commands\CreateItemCommand;
use App\Items\Requests\CreateItemRequest;
use App\Shared\CommandBus\CommandBus;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

final readonly class CreateItemController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private CommandBus $commandBus,
    ) {
    }

    public function createItem(CreateItemRequest $request): JsonResponse
    {
        try {
            /** @var array{'categoryId': string, 'componentId': string} $validated */
            $validated = $request->validated();

            $command = new CreateItemCommand(
                componentId: $validated['componentId'],
                categoryId: $validated['categoryId'],
                userId: RequestHelper::getUserId($request),
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendError(error: 'Item was not successfully created', errorContent: $e->errors());
        } catch (Exception $e) {
            return $this->apiController->sendException(exception: $e);
        }

        return $this->apiController->sendSuccess(message: 'Item was successfully created');
    }
}
