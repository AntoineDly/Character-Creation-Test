<?php

declare(strict_types=1);

namespace App\Categories\Application\Queries\GetCategoriesQuery;

use App\Categories\Domain\Dtos\CategoryDto\CategoryDto;
use App\Categories\Domain\Dtos\CategoryDto\CategoryDtoCollection;
use App\Categories\Domain\Models\Category;
use App\Categories\Domain\Services\CategoryQueriesService;
use App\Categories\Infrastructure\Repositories\CategoryRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationBuilderHelper;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDto;

final readonly class GetCategoriesQueryHandler implements QueryHandlerInterface
{
    /** @use DtosWithPaginationBuilderHelper<Category, CategoryDto> */
    use DtosWithPaginationBuilderHelper;

    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
        private CategoryQueriesService $categoryQueriesService,
    ) {
    }

    /** @return DtosWithPaginationDto<CategoryDto> */
    public function handle(QueryInterface $query): DtosWithPaginationDto
    {
        if (! $query instanceof GetCategoriesQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetCategoriesQuery::class]);
        }
        $categories = $this->categoryRepository->index($query->sortedAndPaginatedDto);

        $dtoCollection = CategoryDtoCollection::fromMap(fn (Category $category) => $this->categoryQueriesService->getCategoryDtoFromModel(category: $category), $categories->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator(readonlyCollection: $dtoCollection->getReadonlyCollection(), lengthAwarePaginator: $categories);
    }
}
