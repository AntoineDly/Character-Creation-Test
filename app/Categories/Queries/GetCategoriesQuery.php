<?php

declare(strict_types=1);

namespace App\Categories\Queries;

use App\Base\Queries\QueryInterface;
use App\Categories\Dtos\CategoryDto;
use App\Categories\Repositories\CategoryRepositoryInterface;
use App\Categories\Services\CategoryQueriesService;

final readonly class GetCategoriesQuery implements QueryInterface
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
        private CategoryQueriesService $categoryQueriesService,
    ) {
    }

    /** @return CategoryDto[] */
    public function get(): mixed
    {
        $categories = $this->categoryRepository->index();

        /** @var CategoryDto[] $categoriesData */
        $categoriesData = [];

        foreach ($categories as $category) {
            $categoriesData[] = $this->categoryQueriesService->getCategoryDtoFromModel(category: $category);
        }

        return $categoriesData;
    }
}
