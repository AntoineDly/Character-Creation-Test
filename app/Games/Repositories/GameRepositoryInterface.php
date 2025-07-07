<?php

declare(strict_types=1);

namespace App\Games\Repositories;

use App\Games\Models\Game;
use App\Shared\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * @extends RepositoryInterface<Game>
 */
interface GameRepositoryInterface extends RepositoryInterface
{
    public function getGameWithCategoriesAndPlayableItemsById(string $id): Game;

    /** @return Collection<int, Game> */
    public function getAllGamesWithoutRequestedCategory(string $userId, string $categoryId): Collection;
}
