<?php

declare(strict_types=1);

namespace App\Categories\Queries;

use App\Base\Queries\QueryInterface;
use App\Categories\Dtos\CategoryDto;
use App\Categories\Repositories\CategoryRepositoryInterface;
use App\Categories\Services\CategoryQueriesService;

final readonly class GetCategoryQuery implements QueryInterface
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
        private CategoryQueriesService $categoryQueriesService,
        private string $categoryId,
    ) {
    }

    /** @return CategoryDto */
    public function get(): mixed
    {
        $category = $this->categoryRepository->findById(id: $this->categoryId);

        return $this->categoryQueriesService->getCategoryDtoFromModel(category: $category);
    }
}
