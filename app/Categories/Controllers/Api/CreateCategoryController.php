<?php

declare(strict_types=1);

namespace App\Categories\Controllers\Api;

use App\Categories\Commands\CreateCategoryCommand;
use App\Categories\Requests\CreateCategoryRequest;
use App\Helpers\RequestHelper;
use App\Shared\CommandBus\CommandBus;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Exceptions\Http\HttpExceptionInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

final readonly class CreateCategoryController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private CommandBus $commandBus,
    ) {
    }

    public function createCategory(CreateCategoryRequest $request): JsonResponse
    {
        try {
            /** @var array{'name': string} $validated */
            $validated = $request->validated();

            $command = new CreateCategoryCommand(
                name: $validated['name'],
                userId: RequestHelper::getUserId($request),
            );

            $this->commandBus->handle($command);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Category was not successfully created.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Exception $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendCreated(message: 'Category was successfully created.');
    }
}
