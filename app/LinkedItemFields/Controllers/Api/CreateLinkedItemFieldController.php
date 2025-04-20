<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Controllers\Api;

use App\Helpers\RequestHelper;
use App\LinkedItemFields\Commands\CreateLinkedItemFieldCommand;
use App\LinkedItemFields\Requests\CreateLinkedItemFieldRequest;
use App\Shared\CommandBus\CommandBus;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Http\Exceptions\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class CreateLinkedItemFieldController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private CommandBus $commandBus,
    ) {
    }

    public function createLinkedItemField(CreateLinkedItemFieldRequest $request): JsonResponse
    {
        try {
            /** @var array{'value': string, 'linkedItemId': string, 'parameterId': string} $validated */
            $validated = $request->validated();

            $command = new CreateLinkedItemFieldCommand(
                value: $validated['value'],
                linkedItemId: $validated['linkedItemId'],
                parameterId: $validated['parameterId'],
                userId: RequestHelper::getUserId($request),
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Linked Item Field was not successfully created.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendCreated(message: 'Linked Item Field was successfully created.');
    }
}
