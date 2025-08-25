<?php

declare(strict_types=1);

namespace App\Categories\Infrastructure\Controllers\Api;

use App\Categories\Application\Queries\GetAllCategoriesQuery\GetAllCategoriesQuery;
use App\Categories\Application\Queries\GetAllCategoriesWithoutRequestedGameQuery\GetAllCategoriesWithoutRequestedGameQuery;
use App\Categories\Application\Queries\GetCategoriesQuery\GetCategoriesQuery;
use App\Categories\Application\Queries\GetCategoryQuery\GetCategoryQuery;
use App\Categories\Infrastructure\Requests\AllCategoriesWithoutRequestedGameRequest;
use App\Helpers\RequestHelper;
use App\Shared\Application\Queries\QueryBus;
use App\Shared\Domain\SortAndPagination\Dtos\SortedAndPaginatedDto\SortedAndPaginatedDto;
use App\Shared\Infrastructure\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Infrastructure\Http\Exceptions\HttpExceptionInterface;
use App\Shared\Infrastructure\Requests\SortedAndPaginatedRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class GetCategoryController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private QueryBus $queryBus,
    ) {
    }

    public function getCategories(SortedAndPaginatedRequest $request): JsonResponse
    {
        try {
            $sortedAndPaginatedDto = SortedAndPaginatedDto::fromSortedAndPaginatedRequest($request);

            $query = new GetCategoriesQuery(
                sortedAndPaginatedDto: $sortedAndPaginatedDto,
            );
            $result = $this->queryBus->dispatch($query);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Categories were not successfully retrieved.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'Categories were successfully retrieved.', content: $result);
    }

    public function getAllCategories(Request $request): JsonResponse
    {
        try {
            $query = new GetAllCategoriesQuery(
                userId: RequestHelper::getUserId($request)
            );
            $result = $this->queryBus->dispatch($query);
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'All Categories were successfully retrieved.', content: $result);
    }

    public function getAllCategoriesWithoutRequestedGame(AllCategoriesWithoutRequestedGameRequest $request): JsonResponse
    {
        try {
            /** @var array{'gameId': string} $validated */
            $validated = $request->validated();

            $query = new GetAllCategoriesWithoutRequestedGameQuery(
                userId: RequestHelper::getUserId($request),
                gameId: $validated['gameId']
            );
            $result = $this->queryBus->dispatch($query);
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'All Categories without requested game were successfully retrieved.', content: $result);
    }

    public function getCategory(string $categoryId): JsonResponse
    {
        try {
            $query = new GetCategoryQuery(
                categoryId: $categoryId
            );
            $result = $this->queryBus->dispatch($query);
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'Category was successfully retrieved.', content: $result);
    }
}
