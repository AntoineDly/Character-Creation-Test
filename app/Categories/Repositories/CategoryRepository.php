<?php

declare(strict_types=1);

namespace App\Categories\Repositories;

use App\Categories\Models\Category;
use App\Helpers\AssertHelper;
use App\Shared\Repositories\AbstractRepository\AbstractRepository;

final readonly class CategoryRepository extends AbstractRepository implements CategoryRepositoryInterface
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function associateGame(string $categoryId, string $gameId): void
    {
        $category = $this->findById(id: $categoryId);

        $category = AssertHelper::isCategory($category);

        $category->games()->attach($gameId);
    }
}
