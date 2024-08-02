<?php

declare(strict_types=1);

namespace App\DefaultFields\Controllers;

use App\Base\CommandBus\CommandBus;
use App\Base\Controllers\ApiController\ApiControllerInterface;
use App\DefaultFields\Commands\CreateDefaultFieldCommand;
use App\DefaultFields\Requests\CreateDefaultFieldRequest;
use App\Helpers\RequestHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

final readonly class CreateDefaultFieldController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private CommandBus $commandBus,
    ) {
    }

    public function createDefaultField(CreateDefaultFieldRequest $request): JsonResponse
    {
        try {
            /** @var array{'value': string, 'itemId': string, 'parameterId': string} $validated */
            $validated = $request->validated();

            $command = new CreateDefaultFieldCommand(
                value: $validated['value'],
                itemId: $validated['itemId'],
                parameterId: $validated['parameterId'],
                userId: RequestHelper::getUserId($request),
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendError(error: 'Default Field was not successfully created', errorContent: $e->errors());
        }

        return $this->apiController->sendSuccess(message: 'Default Field was successfully created');
    }
}
