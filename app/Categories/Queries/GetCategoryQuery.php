<?php

declare(strict_types=1);

namespace App\Categories\Queries;

use App\Categories\Dtos\CategoryDto;
use App\Categories\Repositories\CategoryRepositoryInterface;
use App\Categories\Services\CategoryQueriesService;
use App\Shared\Queries\QueryInterface;

final readonly class GetCategoryQuery implements QueryInterface
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
        private CategoryQueriesService $categoryQueriesService,
        private string $categoryId,
    ) {
    }

    public function get(): CategoryDto
    {
        $category = $this->categoryRepository->findById(id: $this->categoryId);

        return $this->categoryQueriesService->getCategoryDtoFromModel(category: $category);
    }
}
