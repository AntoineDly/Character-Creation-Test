<?php

namespace App\Categories\Application\Queries\GetCategoryQuery;

use App\Categories\Application\Commands\CreateCategoryCommand\CreateCategoryCommand;
use App\Categories\Application\Queries\GetAllCategoriesQuery\GetAllCategoriesQuery;
use App\Categories\Application\Queries\GetAllCategoriesWithoutRequestedGameQuery\GetAllCategoriesWithoutRequestedGameQuery;
use App\Categories\Application\Queries\GetCategoriesQuery\GetCategoriesQuery;
use App\Categories\Domain\Dtos\CategoryDto\CategoryDtoCollection;
use App\Categories\Domain\Models\Category;
use App\Categories\Domain\Services\CategoryQueriesService;
use App\Categories\Infrastructure\Repositories\CategoryRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;
use App\Shared\Domain\Dtos\DtoCollectionInterface;
use App\Shared\Domain\Dtos\DtoInterface;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationBuilderHelper;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDtoBuilder;
use App\Categories\Domain\Dtos\CategoryDto\CategoryDto;

final readonly class GetCategoryQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
        private CategoryQueriesService $categoryQueriesService
    ) {
    }

    public function handle(QueryInterface $query): CategoryDto
    {
        if (! $query instanceof GetCategoryQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetCategoryQuery::class]);
        }
        $category = $this->categoryRepository->findById(id: $query->categoryId);

        return $this->categoryQueriesService->getCategoryDtoFromModel(category: $category);
    }
}
