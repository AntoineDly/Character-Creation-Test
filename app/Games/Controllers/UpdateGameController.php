<?php

declare(strict_types=1);

namespace App\Games\Controllers;

use App\Games\Commands\UpdateGameCommand;
use App\Games\Requests\UpdateGameRequest;
use App\Helpers\RequestHelper;
use App\Shared\CommandBus\CommandBus;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

final readonly class UpdateGameController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private CommandBus $commandBus,
    ) {
    }

    public function updateGame(UpdateGameRequest $request): JsonResponse
    {
        try {
            /** @var array{'id': string, 'name': string, 'visibleForAll': bool} $validated */
            $validated = $request->validated();

            $command = new UpdateGameCommand(
                id: $validated['id'],
                name: $validated['name'],
                visibleForAll: $validated['visibleForAll'],
                userId: RequestHelper::getUserId($request),
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendError(error: 'Game was not successfully updated', errorContent: $e->errors());
        } catch (Exception $e) {
            return $this->apiController->sendException(exception: $e);
        }

        return $this->apiController->sendSuccess(message: 'Game was successfully updated');
    }
}
