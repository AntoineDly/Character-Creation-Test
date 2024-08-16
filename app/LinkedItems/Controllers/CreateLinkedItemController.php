<?php

declare(strict_types=1);

namespace App\LinkedItems\Controllers;

use App\Helpers\RequestHelper;
use App\LinkedItems\Commands\CreateLinkedItemCommand;
use App\LinkedItems\Requests\CreateLinkedItemRequest;
use App\Shared\CommandBus\CommandBus;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

final readonly class CreateLinkedItemController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private CommandBus $commandBus,
    ) {
    }

    public function createLinkedItem(CreateLinkedItemRequest $request): JsonResponse
    {
        try {
            /** @var array{'itemId': string, 'characterId': string} $validated */
            $validated = $request->validated();

            $command = new CreateLinkedItemCommand(
                itemId: $validated['itemId'],
                characterId: $validated['characterId'],
                userId: RequestHelper::getUserId($request),
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendError(error: 'Linked Item was not successfully created', errorContent: $e->errors());
        } catch (Exception $e) {
            return $this->apiController->sendException(exception: $e);
        }

        return $this->apiController->sendSuccess(message: 'Linked Item was successfully created');
    }
}
