<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Controllers\Api;

use App\Helpers\ArrayHelper;
use App\PlayableItemFields\Commands\UpdatePartiallyPlayableItemFieldCommand;
use App\PlayableItemFields\Commands\UpdatePlayableItemFieldCommand;
use App\PlayableItemFields\Requests\UpdatePartiallyPlayableItemFieldRequest;
use App\PlayableItemFields\Requests\UpdatePlayableItemFieldRequest;
use App\Shared\CommandBus\CommandBus;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Http\Exceptions\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class UpdatePlayableItemFieldController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private CommandBus $commandBus,
    ) {
    }

    public function updatePlayableItemField(UpdatePlayableItemFieldRequest $request, string $id): JsonResponse
    {
        try {
            /** @var array{'value': string, 'playableItemId': string, 'parameterId': string} $validated */
            $validated = $request->validated();

            $command = new UpdatePlayableItemFieldCommand(
                id: $id,
                value: $validated['value'],
                playableItemId: $validated['playableItemId'],
                parameterId: $validated['parameterId'],
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Playable Item was not successfully updated.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Playable Item Field was successfully updated.');
    }

    public function updatePartiallyPlayableItemField(UpdatePartiallyPlayableItemFieldRequest $request, string $id): JsonResponse
    {
        try {
            /** @var array{'value': ?string, 'playableItemId': ?string, 'parameterId': ?string} $validated */
            $validated = $request->validated();

            $command = new UpdatePartiallyPlayableItemFieldCommand(
                id: $id,
                value: ArrayHelper::returnNullOrStringValueOfKey(array: $validated, key: 'value'),
                playableItemId: ArrayHelper::returnNullOrStringValueOfKey(array: $validated, key: 'playableItemId'),
                parameterId: ArrayHelper::returnNullOrStringValueOfKey(array: $validated, key: 'parameterId'),
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Playable Item was not successfully updated partially.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Playable Item Field was successfully updated partially.');
    }
}
