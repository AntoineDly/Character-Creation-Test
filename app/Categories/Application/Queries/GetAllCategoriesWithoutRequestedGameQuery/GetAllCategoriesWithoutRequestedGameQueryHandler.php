<?php

namespace App\Categories\Application\Queries\GetAllCategoriesWithoutRequestedGameQuery;

use App\Categories\Application\Commands\CreateCategoryCommand\CreateCategoryCommand;
use App\Categories\Application\Queries\GetAllCategoriesQuery\GetAllCategoriesQuery;
use App\Categories\Domain\Dtos\CategoryDto\CategoryDtoCollection;
use App\Categories\Domain\Models\Category;
use App\Categories\Domain\Services\CategoryQueriesService;
use App\Categories\Infrastructure\Repositories\CategoryRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;
use App\Shared\Domain\Dtos\DtoInterface;

final readonly class GetAllCategoriesWithoutRequestedGameQueryHandler implements QueryHandlerInterface
{
    public function __construct(private CategoryRepositoryInterface $categoryRepository, private CategoryQueriesService $categoryQueriesService)
    {
    }

    public function handle(QueryInterface $query): CategoryDtoCollection
    {
        if (! $query instanceof GetAllCategoriesWithoutRequestedGameQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetAllCategoriesWithoutRequestedGameQuery::class]);
        }
        $categories = $this->categoryRepository->getAllCategoriesWithoutRequestedGame($query->userId, $query->gameId);

        return CategoryDtoCollection::fromMap(fn (Category $category) => $this->categoryQueriesService->getCategoryDtoFromModel(category: $category), $categories->all());
    }
}
