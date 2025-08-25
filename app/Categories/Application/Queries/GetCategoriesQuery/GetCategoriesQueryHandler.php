<?php

namespace App\Categories\Application\Queries\GetCategoriesQuery;

use App\Categories\Application\Commands\CreateCategoryCommand\CreateCategoryCommand;
use App\Categories\Application\Queries\GetAllCategoriesQuery\GetAllCategoriesQuery;
use App\Categories\Application\Queries\GetAllCategoriesWithoutRequestedGameQuery\GetAllCategoriesWithoutRequestedGameQuery;
use App\Categories\Domain\Dtos\CategoryDto\CategoryDto;
use App\Categories\Domain\Dtos\CategoryDto\CategoryDtoCollection;
use App\Categories\Domain\Models\Category;
use App\Categories\Domain\Services\CategoryQueriesService;
use App\Categories\Infrastructure\Repositories\CategoryRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;
use App\Shared\Domain\Dtos\DtoCollectionInterface;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationBuilderHelper;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDtoBuilder;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDto;

final readonly class GetCategoriesQueryHandler implements QueryHandlerInterface
{
    /** @use DtosWithPaginationBuilderHelper<Category> */
    use DtosWithPaginationBuilderHelper;

    /** @param DtosWithPaginationDtoBuilder<Category> $dtosWithPaginationDtoBuilder */
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
        private CategoryQueriesService $categoryQueriesService,
        DtosWithPaginationDtoBuilder $dtosWithPaginationDtoBuilder,
    ) {
        $this->dtosWithPaginationDtoBuilder = $dtosWithPaginationDtoBuilder;
    }

    public function handle(QueryInterface $query): DtosWithPaginationDto
    {
        if (! $query instanceof GetCategoriesQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetCategoriesQuery::class]);
        }
        $categories = $this->categoryRepository->index($query->sortedAndPaginatedDto);

        $dtos = CategoryDtoCollection::fromMap(fn (Category $category) => $this->categoryQueriesService->getCategoryDtoFromModel(category: $category), $categories->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator(dtos: $dtos, lengthAwarePaginator: $categories);
    }
}
