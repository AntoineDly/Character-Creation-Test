<?php

declare(strict_types=1);

namespace App\Items\Controllers;

use App\Base\CommandBus\CommandBus;
use App\Base\Controllers\ApiController\ApiControllerInterface;
use App\Helpers\RequestHelper;
use App\Items\Commands\CreateItemCommand;
use App\Items\Requests\CreateItemRequest;
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
            /** @var array{'name': string} $validated */
            $validated = $request->validated();

            $command = new CreateItemCommand(
                name: $validated['name'],
                userId: RequestHelper::getUserId($request),
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendError(error: 'Item was not successfully created', errorContent: $e->errors());
        }

        return $this->apiController->sendSuccess(message: 'Item was successfully created');
    }
}
