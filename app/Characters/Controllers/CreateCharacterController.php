<?php

declare(strict_types=1);

namespace App\Characters\Controllers;

use App\Characters\Commands\CreateCharacterCommand;
use App\Characters\Requests\CreateCharacterRequest;
use App\Helpers\RequestHelper;
use App\Shared\CommandBus\CommandBus;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

final readonly class CreateCharacterController
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

            $command = new CreateCharacterCommand(
                name: $validated['name'],
                gameId: $validated['gameId'],
                userId: RequestHelper::getUserId($request),
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendError(error: 'Character was not successfully created', errorContent: $e->errors());
        } catch (Exception $e) {
            return $this->apiController->sendException(exception: $e);
        }

        return $this->apiController->sendSuccess(message: 'Character was successfully created');
    }
}
