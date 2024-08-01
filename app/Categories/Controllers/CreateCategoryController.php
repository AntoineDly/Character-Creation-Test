<?php

declare(strict_types=1);

namespace App\Categories\Controllers;

use App\Base\CommandBus\CommandBus;
use App\Base\Controllers\ApiController\ApiControllerInterface;
use App\Categories\Commands\CreateCategoryCommand;
use App\Categories\Requests\CreateCategoryRequest;
use App\Helpers\RequestHelper;
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
            return $this->apiController->sendError(error: 'Category was not successfully created', errorContent: $e->errors());
        }

        return $this->apiController->sendSuccess(message: 'Category was successfully created');
    }
}