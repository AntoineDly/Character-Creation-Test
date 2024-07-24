<?php

declare(strict_types=1);

namespace App\Character\Controllers;

use App\Base\CommandBus\CommandBus;
use App\Base\Controllers\ApiController\ApiControllerInterface;
use App\Character\Commands\CreateCharacterCommand;
use App\Character\Requests\CreateCharacterRequest;
use App\User\Exceptions\UserNotFoundException;
use App\User\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

final class CreateCharacterController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private CommandBus $commandBus,
    ) {
    }

    public function createCharacter(CreateCharacterRequest $request): JsonResponse
    {
        try {
            /** @var array{'name': string, 'gameId': string} $validated */
            $validated = $request->validated();
            /** @var ?User $user */
            $user = $request->user();
            if (! $user instanceof User) {
                throw new UserNotFoundException(message: 'User not found', code: 404);
            }
            /** @var array{'id': string} $userData */
            $userData = $user->toArray();

            $command = new CreateCharacterCommand(
                name: $validated['name'],
                gameId: $validated['gameId'],
                userId: $userData['id'],
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendError(error: 'Character was not successfully created', errorContent: $e->errors());
        }

        return $this->apiController->sendSuccess(message: 'Character was successfully created');
    }
}
