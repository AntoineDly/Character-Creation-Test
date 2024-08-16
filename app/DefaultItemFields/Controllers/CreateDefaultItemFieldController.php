<?php

declare(strict_types=1);

namespace App\DefaultItemFields\Controllers;

use App\DefaultItemFields\Commands\CreateDefaultItemFieldCommand;
use App\DefaultItemFields\Requests\CreateDefaultItemFieldRequest;
use App\Helpers\RequestHelper;
use App\Shared\CommandBus\CommandBus;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

final readonly class CreateDefaultItemFieldController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private CommandBus $commandBus,
    ) {
    }

    public function createDefaultItemField(CreateDefaultItemFieldRequest $request): JsonResponse
    {
        try {
            /** @var array{'value': string, 'itemId': string, 'parameterId': string} $validated */
            $validated = $request->validated();

            $command = new CreateDefaultItemFieldCommand(
                value: $validated['value'],
                itemId: $validated['itemId'],
                parameterId: $validated['parameterId'],
                userId: RequestHelper::getUserId($request),
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendError(error: 'Default Field was not successfully created', errorContent: $e->errors());
        } catch (Exception $e) {
            return $this->apiController->sendException(exception: $e);
        }

        return $this->apiController->sendSuccess(message: 'Default Field was successfully created');
    }
}
