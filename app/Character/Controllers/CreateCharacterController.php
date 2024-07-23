<?php

declare(strict_types=1);

namespace App\Character\Controllers;

use App\Base\CommandBus\CommandBus;
use App\Base\Controllers\ApiController\ApiControllerInterface;
use App\Character\Commands\CreateCharacterCommand;
use App\Character\Requests\CreateCharacterRequest;
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
            /** @var array{'name': string, 'gameId': string, 'userId': string} $validated */
            $validated = $request->validated();

            $command = new CreateCharacterCommand(
                name: $validated['name'],
                gameId: $validated['gameId'],
                userId: $validated['userId'],
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendError(error: 'Character was not successfully created', errorContent: $e->errors());
        }

        return $this->apiController->sendSuccess(message: 'Character was successfully created');
    }
}
