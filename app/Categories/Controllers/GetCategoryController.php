<?php

declare(strict_types=1);

namespace App\Categories\Controllers;

use App\Base\Controllers\ApiController\ApiControllerInterface;
use App\Categories\Queries\GetCategoriesQuery;
use App\Categories\Queries\GetCategoryQuery;
use App\Categories\Repositories\CategoryRepositoryInterface;
use App\Categories\Services\CategoryQueriesService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

final class GetCategoryController extends Controller
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
        private CategoryQueriesService $categoryQueriesService,
        private ApiControllerInterface $apiController,
    ) {
    }

    public function getCategories(): JsonResponse
    {
        try {
            $query = new GetCategoriesQuery(
                categoryRepository: $this->categoryRepository,
                categoryQueriesService: $this->categoryQueriesService,
            );
            $result = $query->get();
        } catch (Exception $e) {
            return $this->apiController->sendException(exception: $e);
        }

        return $this->apiController->sendSuccess(message: 'Categories were successfully retrieved', content: [$result]);
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
        } catch (Exception $e) {
            return $this->apiController->sendException(exception: $e);
        }

        return $this->apiController->sendSuccess(message: 'Category was successfully retrieved', content: [$result]);
    }
}
