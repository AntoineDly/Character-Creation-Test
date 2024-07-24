<?php

declare(strict_types=1);

namespace App\Game\Controllers;

use App\Base\CommandBus\CommandBus;
use App\Base\Controllers\ApiController\ApiControllerInterface;
use App\Game\Commands\CreateGameCommand;
use App\Game\Requests\CreateGameRequest;
use App\User\Exceptions\UserNotFoundException;
use App\User\Models\User;
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
            /** @var array{'name': string, 'visibleForAll': bool} $validated */
            $validated = $request->validated();
            /** @var ?User $user */
            $user = $request->user();
            if (! $user instanceof User) {
                throw new UserNotFoundException(message: 'User not found', code: 404);
            }
            /** @var array{'id': string} $userData */
            $userData = $user->toArray();

            $command = new CreateGameCommand(
                name: $validated['name'],
                visibleForAll: $validated['visibleForAll'],
                userId: $userData['id'],
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendError(error: 'Game was not successfully created', errorContent: $e->errors());
        }

        return $this->apiController->sendSuccess(message: 'Game was successfully created');
    }
}
