<?php

declare(strict_types=1);

namespace App\Categories\Application\Queries\GetAllCategoriesQuery;

use App\Categories\Domain\Collection\CategoryDtoCollection;
use App\Categories\Domain\Models\Category;
use App\Categories\Domain\Services\CategoryQueriesService;
use App\Categories\Infrastructure\Repositories\CategoryRepositoryInterface;
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
