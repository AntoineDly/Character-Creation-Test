<?php

declare(strict_types=1);

namespace App\Categories\Queries;

use App\Categories\Dtos\CategoryDto;
use App\Categories\Repositories\CategoryRepositoryInterface;
use App\Categories\Services\CategoryQueriesService;
use App\Shared\Dtos\SortedAndPaginatedDto;
use App\Shared\Queries\QueryInterface;
use Illuminate\Database\Eloquent\Model;

final readonly class GetCategoriesQuery implements QueryInterface
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
        private CategoryQueriesService $categoryQueriesService,
        private SortedAndPaginatedDto $sortedAndPaginatedDto,
    ) {
    }

    /** @return CategoryDto[] */
    public function get(): array
    {
        $categories = $this->categoryRepository->index($this->sortedAndPaginatedDto);

        return array_map(fn (?Model $category) => $this->categoryQueriesService->getCategoryDtoFromModel(category: $category), $categories->items());
    }
}
