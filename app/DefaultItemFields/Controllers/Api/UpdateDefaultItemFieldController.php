<?php

declare(strict_types=1);

namespace App\DefaultItemFields\Controllers\Api;

use App\DefaultItemFields\Commands\UpdateDefaultItemFieldCommand;
use App\DefaultItemFields\Commands\UpdatePartiallyDefaultItemFieldCommand;
use App\DefaultItemFields\Requests\UpdateDefaultItemFieldRequest;
use App\DefaultItemFields\Requests\UpdatePartiallyDefaultItemFieldRequest;
use App\Helpers\ArrayHelper;
use App\Shared\CommandBus\CommandBus;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Exceptions\Http\HttpExceptionInterface;
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
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Default Item Field was not successfully updated.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Exception $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Default Item Field was successfully updated.');
    }

    public function updatePartiallyDefaultItemField(UpdatePartiallyDefaultItemFieldRequest $request, string $id): JsonResponse
    {
        try {
            /** @var array{'value': ?string, 'itemId': ?string, 'parameterId': ?string} $validated */
            $validated = $request->validated();

            $command = new UpdatePartiallyDefaultItemFieldCommand(
                id: $id,
                value: ArrayHelper::returnNullOrStringValueOfKey(array: $validated, key: 'value'),
                itemId: ArrayHelper::returnNullOrStringValueOfKey(array: $validated, key: 'itemId'),
                parameterId: ArrayHelper::returnNullOrStringValueOfKey(array: $validated, key: 'parameterId'),
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Default Item Field was not successfully updated partially.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Exception $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Default Item Field was successfully updated partially.');
    }
}
