<?php

declare(strict_types=1);

namespace App\ComponentFields\Infrastructure\Controllers\Patch\UpdatePartiallyComponentField;

use App\ComponentFields\Application\Commands\UpdatePartiallyComponentFieldCommand\UpdatePartiallyComponentFieldCommand;
use App\Helpers\ArrayHelper;
use App\Shared\Application\Commands\CommandBus;
use App\Shared\Infrastructure\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Infrastructure\Http\Exceptions\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class UpdatePartiallyComponentFieldController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private CommandBus $commandBus,
    ) {
    }

    public function __invoke(UpdatePartiallyComponentFieldRequest $request, string $id): JsonResponse
    {
        try {
            /** @var array{'value': ?string, 'componentId': ?string, 'parameterId': ?string} $validated */
            $validated = $request->validated();

            $command = new UpdatePartiallyComponentFieldCommand(
                id: $id,
                value: ArrayHelper::returnNullOrStringValueOfKey(array: $validated, key: 'value'),
                componentId: ArrayHelper::returnNullOrStringValueOfKey(array: $validated, key: 'componentId'),
                parameterId: ArrayHelper::returnNullOrStringValueOfKey(array: $validated, key: 'parameterId'),
            );

            $this->commandBus->dispatch($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Component was not successfully updated partially.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'ComponentField was successfully updated partially.');
    }
}
