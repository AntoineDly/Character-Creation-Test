<?php

declare(strict_types=1);

namespace App\Categories\Queries;

use App\Categories\Dtos\CategoryDto;
use App\Categories\Repositories\CategoryRepositoryInterface;
use App\Categories\Services\CategoryQueriesService;
use App\Shared\Queries\QueryInterface;

final readonly class GetCategoriesQuery implements QueryInterface
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
        private CategoryQueriesService $categoryQueriesService,
    ) {
    }

    /** @return CategoryDto[] */
    public function get(): array
    {
        $categories = $this->categoryRepository->index();

        /** @var CategoryDto[] $categoriesDtos */
        $categoriesDtos = [];

        foreach ($categories as $category) {
            $categoriesDtos[] = $this->categoryQueriesService->getCategoryDtoFromModel(category: $category);
        }

        return $categoriesDtos;
    }
}
