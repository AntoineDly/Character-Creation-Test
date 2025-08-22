<?php

declare(strict_types=1);

namespace App\Categories\Infrastructure\Controllers\Api;

use App\Categories\Application\Queries\GetAllCategoriesQuery\GetAllCategoriesQuery;
use App\Categories\Application\Queries\GetAllCategoriesWithoutRequestedGameQuery\GetAllCategoriesWithoutRequestedGameQuery;
use App\Categories\Application\Queries\GetCategoriesQuery\GetCategoriesQuery;
use App\Categories\Application\Queries\GetCategoryQuery\GetCategoryQuery;
use App\Categories\Domain\Models\Category;
use App\Categories\Domain\Services\CategoryQueriesService;
use App\Categories\Infrastructure\Repositories\CategoryRepositoryInterface;
use App\Categories\Infrastructure\Requests\AllCategoriesWithoutRequestedGameRequest;
use App\Helpers\RequestHelper;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Http\Exceptions\HttpExceptionInterface;
use App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDtoBuilder;
use App\Shared\SortAndPagination\Dtos\SortedAndPaginatedDto\SortedAndPaginatedDto;
use App\Shared\SortAndPagination\Dtos\SortedAndPaginatedDto\SortedAndPaginatedRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class GetCategoryController
{
    /** @param DtosWithPaginationDtoBuilder<Category> $dtosWithPaginationDtoBuilder */
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
        private CategoryQueriesService $categoryQueriesService,
        private ApiControllerInterface $apiController,
        private DtosWithPaginationDtoBuilder $dtosWithPaginationDtoBuilder,
    ) {
    }

    public function getCategories(SortedAndPaginatedRequest $request): JsonResponse
    {
        try {
            $sortedAndPaginatedDto = SortedAndPaginatedDto::fromSortedAndPaginatedRequest($request);

            $query = new GetCategoriesQuery(
                categoryRepository: $this->categoryRepository,
                categoryQueriesService: $this->categoryQueriesService,
                sortedAndPaginatedDto: $sortedAndPaginatedDto,
                dtosWithPaginationDtoBuilder: $this->dtosWithPaginationDtoBuilder,
            );
            $result = $query->get();
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
                categoryRepository: $this->categoryRepository,
                categoryQueriesService: $this->categoryQueriesService,
                userId: RequestHelper::getUserId($request)
            );
            $result = $query->get();
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
                categoryRepository: $this->categoryRepository,
                categoryQueriesService: $this->categoryQueriesService,
                userId: RequestHelper::getUserId($request),
                gameId: $validated['gameId']
            );
            $result = $query->get();
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
                categoryRepository: $this->categoryRepository,
                categoryQueriesService: $this->categoryQueriesService,
                categoryId: $categoryId
            );
            $result = $query->get();
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'Category was successfully retrieved.', content: $result);
    }
}
