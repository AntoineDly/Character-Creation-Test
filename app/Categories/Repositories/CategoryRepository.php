<?php

declare(strict_types=1);

namespace App\Categories\Repositories;

use App\Categories\Models\Category;
use App\Helpers\AssertHelper;
use App\Shared\Repositories\RepositoryTrait;

final readonly class CategoryRepository implements CategoryRepositoryInterface
{
    use RepositoryTrait;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function associateGame(string $categoryId, string $gameId): void
    {
        $category = $this->findById(id: $categoryId);

        $category = AssertHelper::isCategory($category);

        $category->games()->attach($gameId);
    }
}
