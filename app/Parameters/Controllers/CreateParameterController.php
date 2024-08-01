<?php

declare(strict_types=1);

namespace App\Parameters\Controllers;

use App\Base\CommandBus\CommandBus;
use App\Base\Controllers\ApiController\ApiControllerInterface;
use App\Helpers\RequestHelper;
use App\Parameters\Commands\CreateParameterCommand;
use App\Parameters\Requests\CreateParameterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

final readonly class CreateParameterController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private CommandBus $commandBus,
    ) {
    }

    public function createParameter(CreateParameterRequest $request): JsonResponse
    {
        try {
            /** @var array{'name': string, 'type': string} $validated */
            $validated = $request->validated();

            $command = new CreateParameterCommand(
                name: $validated['name'],
                type: $validated['type'],
                userId: RequestHelper::getUserId($request),
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendError(error: 'Parameter was not successfully created', errorContent: $e->errors());
        }

        return $this->apiController->sendSuccess(message: 'Parameter was successfully created');
    }
}
