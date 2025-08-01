<?php

declare(strict_types=1);

namespace App\Categories\Queries;

use App\Categories\Collection\CategoryDtoCollection;
use App\Categories\Models\Category;
use App\Categories\Repositories\CategoryRepositoryInterface;
use App\Categories\Services\CategoryQueriesService;
use App\Shared\Queries\QueryInterface;

final readonly class GetAllCategoriesQuery implements QueryInterface
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
        private CategoryQueriesService $categoryQueriesService,
        private string $userId
    ) {
    }

    public function get(): CategoryDtoCollection
    {
        $categories = $this->categoryRepository->all($this->userId);

        return CategoryDtoCollection::fromMap(fn (Category $category) => $this->categoryQueriesService->getCategoryDtoFromModel(category: $category), $categories->all());
    }
}
