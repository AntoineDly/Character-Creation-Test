<?php

declare(strict_types=1);

namespace App\Character\Controllers;

use App\Base\CommandBus\CommandBus;
use App\Base\Controllers\ApiController\ApiControllerInterface;
use App\Character\Commands\CreateCharacterCommand;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Mockery\Exception;

final class CreateCharacterController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private CommandBus $commandBus,
    ) {
    }

    /** @todo handle better request validation */
    public function createCharacter(Request $request): JsonResponse
    {
        $name = $request->get('name');

        if (! is_string($name)) {
            return $this->apiController->sendError(error: 'name was supposed to be string', errorContent: [$name, gettype($name)]);
        }
        try {
            $command = new CreateCharacterCommand(
                name: $name,
            );

            $this->commandBus->handle($command);
        } catch (Exception $e) {
            return $this->apiController->sendError(error: $e->getMessage());
        }

        return $this->apiController->sendSuccess(message: 'Character were successfully created');
    }
}
