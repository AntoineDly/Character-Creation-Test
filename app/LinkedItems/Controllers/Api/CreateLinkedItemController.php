<?php

declare(strict_types=1);

namespace App\LinkedItems\Controllers\Api;

use App\Helpers\RequestHelper;
use App\LinkedItems\Commands\CreateLinkedItemCommand;
use App\LinkedItems\Requests\CreateLinkedItemRequest;
use App\Shared\CommandBus\CommandBus;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Exceptions\Http\HttpExceptionInterface;
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
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Linked Item was not successfully created.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException(exception: $e);
        } catch (Exception $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendCreated(message: 'Linked Item was successfully created.');
    }
}
