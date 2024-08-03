<?php

declare(strict_types=1);

namespace App\Parameters\Controllers;

use App\Helpers\RequestHelper;
use App\Parameters\Commands\CreateParameterCommand;
use App\Parameters\Requests\CreateParameterRequest;
use App\Shared\CommandBus\CommandBus;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use Exception;
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
        } catch (Exception $e) {
            return $this->apiController->sendException(exception: $e);
        }

        return $this->apiController->sendSuccess(message: 'Parameter was successfully created');
    }
}
