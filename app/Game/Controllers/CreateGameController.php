<?php

declare(strict_types=1);

namespace App\Game\Controllers;

use App\Base\CommandBus\CommandBus;
use App\Base\Controllers\ApiController\ApiControllerInterface;
use App\Game\Commands\CreateGameCommand;
use App\Game\Requests\CreateGameRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

final class CreateGameController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private CommandBus $commandBus,
    ) {
    }

    public function createGame(CreateGameRequest $request): JsonResponse
    {
        try {
            /** @var array{'name': string} $validated */
            $validated = $request->validated();

            $command = new CreateGameCommand(
                name: $validated['name'],
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendError(error: 'Game was not successfully created', errorContent: $e->errors());
        }

        return $this->apiController->sendSuccess(message: 'Game was successfully created');
    }
}
