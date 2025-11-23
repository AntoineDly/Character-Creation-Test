<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Infrastructure\Controllers\Post\CreatePlayableItemField;

use App\Helpers\RequestHelper;
use App\PlayableItemFields\Application\Commands\CreatePlayableItemFieldCommand\CreatePlayableItemFieldCommand;
use App\Shared\Application\Commands\CommandBus;
use App\Shared\Infrastructure\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Infrastructure\Http\Exceptions\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class CreatePlayableItemFieldController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private CommandBus $commandBus,
    ) {
    }

    public function __invoke(CreatePlayableItemFieldRequest $request): JsonResponse
    {
        try {
            /** @var array{'value': string, 'playableItemId': string, 'parameterId': string} $validated */
            $validated = $request->validated();

            $command = new CreatePlayableItemFieldCommand(
                value: $validated['value'],
                playableItemId: $validated['playableItemId'],
                parameterId: $validated['parameterId'],
                userId: RequestHelper::getUserId($request),
            );

            $this->commandBus->dispatch($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'PlayableItem Field was not successfully created.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendCreated(message: 'PlayableItem Field was successfully created.');
    }
}
