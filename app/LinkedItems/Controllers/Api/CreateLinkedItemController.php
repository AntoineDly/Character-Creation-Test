<?php

declare(strict_types=1);

namespace App\LinkedItems\Controllers\Api;

use App\Helpers\RequestHelper;
use App\LinkedItems\Commands\CreateLinkedItemCommand;
use App\LinkedItems\Requests\CreateLinkedItemRequest;
use App\Shared\CommandBus\CommandBus;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Http\Exceptions\HttpExceptionInterface;
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

            $this->commandBus->handle($command);
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
