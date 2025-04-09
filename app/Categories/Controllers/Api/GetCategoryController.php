<?php

declare(strict_types=1);

namespace App\Categories\Controllers\Api;

use App\Categories\Queries\GetCategoriesQuery;
use App\Categories\Queries\GetCategoryQuery;
use App\Categories\Repositories\CategoryRepositoryInterface;
use App\Categories\Services\CategoryQueriesService;
use App\Shared\Builders\DtosWithPaginationDtoBuilder;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Dtos\SortedAndPaginatedDto;
use App\Shared\Exceptions\Http\HttpExceptionInterface;
use App\Shared\Requests\SortedAndPaginatedRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class GetCategoryController
{
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
            /** @var array{'sortOrder': string, 'perPage': int, 'page': int} $validatedData */
            $validatedData = $request->validated();
            $sortedAndPaginatedDto = SortedAndPaginatedDto::fromArray($validatedData);

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
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Categories were successfully retrieved.', content: $result);
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
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Category was successfully retrieved.', content: $result);
    }
}
