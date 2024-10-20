<?php

declare(strict_types=1);

namespace App\Fields\Controllers\Api;

use App\Fields\Commands\UpdateFieldCommand;
use App\Fields\Commands\UpdatePartiallyFieldCommand;
use App\Fields\Requests\UpdateFieldRequest;
use App\Fields\Requests\UpdatePartiallyFieldRequest;
use App\Shared\CommandBus\CommandBus;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

final readonly class UpdateFieldController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private CommandBus $commandBus,
    ) {
    }

    public function updateField(UpdateFieldRequest $request, string $id): JsonResponse
    {
        try {
            /** @var array{'value': string, 'linkedItemId': string, 'parameterId': string} $validated */
            $validated = $request->validated();

            $command = new UpdateFieldCommand(
                id: $id,
                value: $validated['value'],
                linkedItemId: $validated['linkedItemId'],
                parameterId: $validated['parameterId']
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendError(error: 'Field was not successfully updated', errorContent: $e->errors());
        } catch (Exception $e) {
            return $this->apiController->sendException(exception: $e);
        }

        return $this->apiController->sendSuccess(message: 'Field was successfully updated');
    }

    public function updatePartiallyField(UpdatePartiallyFieldRequest $request, string $id): JsonResponse
    {
        try {
            /** @var array{'value': ?string, 'linkedItemId': ?string, 'parameterId': ?string} $validated */
            $validated = $request->validated();

            $command = new UpdatePartiallyFieldCommand(
                id: $id,
                value: $validated['value'],
                linkedItemId: $validated['linkedItemId'],
                parameterId: $validated['parameterId']
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendError(error: 'Field was not successfully updated partially', errorContent: $e->errors());
        } catch (Exception $e) {
            return $this->apiController->sendException(exception: $e);
        }

        return $this->apiController->sendSuccess(message: 'Field was successfully updated partially');
    }
}
