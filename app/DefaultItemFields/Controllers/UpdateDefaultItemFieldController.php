<?php

declare(strict_types=1);

namespace App\DefaultItemFields\Controllers;

use App\DefaultItemFields\Commands\UpdateDefaultItemFieldCommand;
use App\DefaultItemFields\Commands\UpdatePartiallyDefaultItemFieldCommand;
use App\DefaultItemFields\Requests\UpdateDefaultItemFieldRequest;
use App\DefaultItemFields\Requests\UpdatePartiallyDefaultItemFieldRequest;
use App\Shared\CommandBus\CommandBus;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

final readonly class UpdateDefaultItemFieldController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private CommandBus $commandBus,
    ) {
    }

    public function updateDefaultItemField(UpdateDefaultItemFieldRequest $request, string $id): JsonResponse
    {
        try {
            /** @var array{'value': string, 'itemId': string, 'parameterId': string} $validated */
            $validated = $request->validated();

            $command = new UpdateDefaultItemFieldCommand(
                id: $id,
                value: $validated['value'],
                itemId: $validated['itemId'],
                parameterId: $validated['parameterId'],
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendError(error: 'Default Item Field was not successfully updated', errorContent: $e->errors());
        } catch (Exception $e) {
            return $this->apiController->sendException(exception: $e);
        }

        return $this->apiController->sendSuccess(message: 'Default Item Field was successfully updated');
    }

    public function updatePartiallyDefaultItemField(UpdatePartiallyDefaultItemFieldRequest $request, string $id): JsonResponse
    {
        try {
            /** @var array{'value': ?string, 'itemId': ?string, 'parameterId': ?string} $validated */
            $validated = $request->validated();

            $command = new UpdatePartiallyDefaultItemFieldCommand(
                id: $id,
                value: $validated['value'],
                itemId: $validated['itemId'],
                parameterId: $validated['parameterId'],
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendError(error: 'Default Item Field was not successfully updated partially', errorContent: $e->errors());
        } catch (Exception $e) {
            return $this->apiController->sendException(exception: $e);
        }

        return $this->apiController->sendSuccess(message: 'Default Item Field was successfully updated partially');
    }
}
