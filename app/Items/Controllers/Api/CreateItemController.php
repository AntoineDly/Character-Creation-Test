<?php

declare(strict_types=1);

namespace App\Items\Controllers\Api;

use App\Helpers\RequestHelper;
use App\Items\Commands\CreateItemCommand;
use App\Items\Requests\CreateItemRequest;
use App\Shared\CommandBus\CommandBus;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Http\Exceptions\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

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
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Item was not successfully created.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendCreated(message: 'Item was successfully created.');
    }
}
