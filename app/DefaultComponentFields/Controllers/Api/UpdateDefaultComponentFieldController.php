<?php

declare(strict_types=1);

namespace App\DefaultComponentFields\Controllers\Api;

use App\DefaultComponentFields\Commands\UpdateDefaultComponentFieldCommand;
use App\DefaultComponentFields\Commands\UpdatePartiallyDefaultComponentFieldCommand;
use App\DefaultComponentFields\Requests\UpdateDefaultComponentFieldRequest;
use App\DefaultComponentFields\Requests\UpdatePartiallyDefaultComponentFieldRequest;
use App\Helpers\ArrayHelper;
use App\Shared\CommandBus\CommandBus;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Exceptions\Http\HttpExceptionInterface;
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
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Default Component was not successfully updated.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Exception $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Default Component Field was successfully updated.');
    }

    public function updatePartiallyDefaultComponentField(UpdatePartiallyDefaultComponentFieldRequest $request, string $id): JsonResponse
    {
        try {
            /** @var array{'value': ?string, 'componentId': ?string, 'parameterId': ?string} $validated */
            $validated = $request->validated();

            $command = new UpdatePartiallyDefaultComponentFieldCommand(
                id: $id,
                value: ArrayHelper::returnNullOrStringValueOfKey(array: $validated, key: 'value'),
                componentId: ArrayHelper::returnNullOrStringValueOfKey(array: $validated, key: 'componentId'),
                parameterId: ArrayHelper::returnNullOrStringValueOfKey(array: $validated, key: 'parameterId'),
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Default Component was not successfully updated partially.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Exception $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Default Component Field was successfully updated partially.');
    }
}
