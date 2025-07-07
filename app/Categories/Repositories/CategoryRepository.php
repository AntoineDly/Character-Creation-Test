<?php

declare(strict_types=1);

namespace App\Categories\Repositories;

use App\Categories\Models\Category;
use App\Helpers\AssertHelper;
use App\Shared\Repositories\RepositoryTrait;
use Illuminate\Database\Eloquent\Collection;

final readonly class CategoryRepository implements CategoryRepositoryInterface
{
    /** @use RepositoryTrait<Category> */
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

    /** @return Collection<int, Category> */
    public function getAllCategoriesWithoutRequestedGame(string $userId, string $gameId): Collection
    {
        return $this->queryWhereUserId($userId)->doesntHave(relation: 'games', callback: function ($query) use ($gameId) {
            $query->where('games.id', $gameId);
        })->get();
    }
}
