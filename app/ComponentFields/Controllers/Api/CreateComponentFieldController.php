<?php

declare(strict_types=1);

namespace App\ComponentFields\Controllers\Api;

use App\ComponentFields\Commands\CreateComponentFieldCommand;
use App\ComponentFields\Requests\CreateComponentFieldRequest;
use App\Helpers\RequestHelper;
use App\Shared\CommandBus\CommandBus;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Http\Exceptions\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class CreateComponentFieldController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private CommandBus $commandBus,
    ) {
    }

    public function createComponentField(CreateComponentFieldRequest $request): JsonResponse
    {
        try {
            /** @var array{'value': string, 'componentId': string, 'parameterId': string} $validated */
            $validated = $request->validated();

            $command = new CreateComponentFieldCommand(
                value: $validated['value'],
                componentId: $validated['componentId'],
                parameterId: $validated['parameterId'],
                userId: RequestHelper::getUserId($request),
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'ComponentFieldas not successfully created.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendCreated(message: 'ComponentFieldas successfully created.');
    }
}
