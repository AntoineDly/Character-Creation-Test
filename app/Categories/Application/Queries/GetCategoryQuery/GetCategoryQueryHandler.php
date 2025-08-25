<?php

declare(strict_types=1);

namespace App\Categories\Application\Queries\GetCategoryQuery;

use App\Categories\Domain\Dtos\CategoryDto\CategoryDto;
use App\Categories\Domain\Services\CategoryQueriesService;
use App\Categories\Infrastructure\Repositories\CategoryRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;

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
