<?php

declare(strict_types=1);

namespace App\Categories\Application\Queries\GetCategoryQuery;

use App\Categories\Domain\Dtos\CategoryDto;
use App\Categories\Domain\Services\CategoryQueriesService;
use App\Categories\Infrastructure\Repositories\CategoryRepositoryInterface;
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
