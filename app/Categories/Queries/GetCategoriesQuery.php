<?php

declare(strict_types=1);

namespace App\Categories\Queries;

use App\Categories\Collection\CategoryDtoCollection;
use App\Categories\Models\Category;
use App\Categories\Repositories\CategoryRepositoryInterface;
use App\Categories\Services\CategoryQueriesService;
use App\Shared\Collection\DtoCollectionInterface;
use App\Shared\Queries\QueryInterface;
use App\Shared\SortAndPagination\Builders\DtosWithPaginationDtoBuilder;
use App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto;
use App\Shared\SortAndPagination\Dtos\SortedAndPaginatedDto;
use App\Shared\SortAndPagination\Traits\DtosWithPaginationBuilderHelper;

final readonly class GetCategoriesQuery implements QueryInterface
{
    /** @use DtosWithPaginationBuilderHelper<Category> */
    use DtosWithPaginationBuilderHelper;

    /** @param DtosWithPaginationDtoBuilder<Category> $dtosWithPaginationDtoBuilder */
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
        private CategoryQueriesService $categoryQueriesService,
        private SortedAndPaginatedDto $sortedAndPaginatedDto,
        DtosWithPaginationDtoBuilder $dtosWithPaginationDtoBuilder,
    ) {
        $this->dtosWithPaginationDtoBuilder = $dtosWithPaginationDtoBuilder;
    }

    /** @return DtosWithPaginationDto<Category> */
    public function get(): DtosWithPaginationDto
    {
        $categories = $this->categoryRepository->index($this->sortedAndPaginatedDto);

        /** @var DtoCollectionInterface<Category> $dtos */
        $dtos = CategoryDtoCollection::fromMap(fn (Category $category) => $this->categoryQueriesService->getCategoryDtoFromModel(category: $category), $categories->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator(dtos: $dtos, lengthAwarePaginator: $categories);
    }
}
