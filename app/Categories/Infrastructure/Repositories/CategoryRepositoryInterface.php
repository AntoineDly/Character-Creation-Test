<?php

declare(strict_types=1);

namespace App\Categories\Infrastructure\Repositories;

use App\Categories\Domain\Models\Category;
use App\Shared\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * @extends RepositoryInterface<Category>
 */
interface CategoryRepositoryInterface extends RepositoryInterface
{
    public function associateGame(string $categoryId, string $gameId): void;

    /** @return Collection<int, Category> */
    public function getAllCategoriesWithoutRequestedGame(string $userId, string $gameId): Collection;
}
