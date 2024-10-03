<?php

declare(strict_types=1);

namespace App\DefaultComponentFields\Controllers;

use App\DefaultComponentFields\Commands\UpdateDefaultComponentFieldCommand;
use App\DefaultComponentFields\Commands\UpdatePartiallyDefaultComponentFieldCommand;
use App\DefaultComponentFields\Requests\UpdateDefaultComponentFieldRequest;
use App\Shared\CommandBus\CommandBus;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

final readonly class UpdateDefaultComponentFieldController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private CommandBus $commandBus,
    ) {
    }

    public function updateDefaultComponentField(UpdateDefaultComponentFieldRequest $request, string $id): JsonResponse
    {
        try {
            /** @var array{'value': string, 'componentId': string, 'parameterId': string} $validated */
            $validated = $request->validated();

            $command = new UpdateDefaultComponentFieldCommand(
                id: $id,
                value: $validated['value'],
                componentId: $validated['componentId'],
                parameterId: $validated['parameterId'],
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendError(error: 'Default Component Field was not successfully updated', errorContent: $e->errors());
        } catch (Exception $e) {
            return $this->apiController->sendException(exception: $e);
        }

        return $this->apiController->sendSuccess(message: 'Default Component Field was successfully updated');
    }

    public function updatePartiallyDefaultComponentField(UpdateDefaultComponentFieldRequest $request, string $id): JsonResponse
    {
        try {
            /** @var array{'value': ?string, 'componentId': ?string, 'parameterId': ?string} $validated */
            $validated = $request->validated();

            $command = new UpdatePartiallyDefaultComponentFieldCommand(
                id: $id,
                value: $validated['value'],
                componentId: $validated['componentId'],
                parameterId: $validated['parameterId'],
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendError(error: 'Default Component Field was not successfully updated partially', errorContent: $e->errors());
        } catch (Exception $e) {
            return $this->apiController->sendException(exception: $e);
        }

        return $this->apiController->sendSuccess(message: 'Default Component Field was successfully updated partially');
    }
}
