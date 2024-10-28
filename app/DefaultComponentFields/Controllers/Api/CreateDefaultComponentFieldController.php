<?php

declare(strict_types=1);

namespace App\DefaultComponentFields\Controllers\Api;

use App\DefaultComponentFields\Commands\CreateDefaultComponentFieldCommand;
use App\DefaultComponentFields\Requests\CreateDefaultComponentFieldRequest;
use App\Helpers\RequestHelper;
use App\Shared\CommandBus\CommandBus;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Exceptions\Http\HttpExceptionInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

final readonly class CreateDefaultComponentFieldController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private CommandBus $commandBus,
    ) {
    }

    public function createDefaultComponentField(CreateDefaultComponentFieldRequest $request): JsonResponse
    {
        try {
            /** @var array{'value': string, 'componentId': string, 'parameterId': string} $validated */
            $validated = $request->validated();

            $command = new CreateDefaultComponentFieldCommand(
                value: $validated['value'],
                componentId: $validated['componentId'],
                parameterId: $validated['parameterId'],
                userId: RequestHelper::getUserId($request),
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Default Component was not successfully created.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException(exception: $e);
        } catch (Exception $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendCreated(message: 'Default Component Field was successfully created.');
    }
}
