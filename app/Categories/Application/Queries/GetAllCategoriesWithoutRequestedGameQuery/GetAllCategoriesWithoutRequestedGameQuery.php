<?php

declare(strict_types=1);

namespace App\Categories\Application\Queries\GetAllCategoriesWithoutRequestedGameQuery;

use App\Categories\Domain\Dtos\CategoryDto\CategoryDtoCollection;
use App\Categories\Domain\Models\Category;
use App\Categories\Domain\Services\CategoryQueriesService;
use App\Categories\Infrastructure\Repositories\CategoryRepositoryInterface;
use App\Shared\Queries\QueryInterface;

final readonly class GetAllCategoriesWithoutRequestedGameQuery implements QueryInterface
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
        private CategoryQueriesService $categoryQueriesService,
        private string $userId,
        private string $gameId,
    ) {
    }

    public function get(): CategoryDtoCollection
    {
        $categories = $this->categoryRepository->getAllCategoriesWithoutRequestedGame($this->userId, $this->gameId);

        return CategoryDtoCollection::fromMap(fn (Category $category) => $this->categoryQueriesService->getCategoryDtoFromModel(category: $category), $categories->all());
    }
}
