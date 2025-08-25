<?php

declare(strict_types=1);

namespace App\LinkedItems\Infrastructure\Controllers\Api;

use App\Helpers\RequestHelper;
use App\LinkedItems\Application\Commands\CreateLinkedItemCommand\CreateLinkedItemCommand;
use App\LinkedItems\Infrastructure\Requests\CreateLinkedItemRequest;
use App\Shared\Application\Commands\CommandBus;
use App\Shared\Infrastructure\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Infrastructure\Http\Exceptions\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

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
            /** @var array{'playableItemId': string, 'characterId': string} $validated */
            $validated = $request->validated();

            $command = new CreateLinkedItemCommand(
                playableItemId: $validated['playableItemId'],
                characterId: $validated['characterId'],
                userId: RequestHelper::getUserId($request),
            );

            $this->commandBus->dispatch($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'LinkedItem was not successfully created.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendCreated(message: 'LinkedItem was successfully created.');
    }
}
