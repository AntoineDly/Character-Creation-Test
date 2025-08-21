<?php

declare(strict_types=1);

namespace App\ItemFields\Infrastructure\Controllers\Api;

use App\Helpers\RequestHelper;
use App\ItemFields\Application\Commands\CreateItemFieldCommand\CreateItemFieldCommand;
use App\ItemFields\Infrastructure\Requests\CreateItemFieldRequest;
use App\Shared\CommandBus\CommandBus;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Http\Exceptions\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class CreateItemFieldController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private CommandBus $commandBus,
    ) {
    }

    public function createItemField(CreateItemFieldRequest $request): JsonResponse
    {
        try {
            /** @var array{'value': string, 'itemId': string, 'parameterId': string} $validated */
            $validated = $request->validated();

            $command = new CreateItemFieldCommand(
                value: $validated['value'],
                itemId: $validated['itemId'],
                parameterId: $validated['parameterId'],
                userId: RequestHelper::getUserId($request),
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'ItemField was not successfully created.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendCreated(message: 'ItemField was successfully created.');
    }
}
