<?php

declare(strict_types=1);

namespace App\Games\Infrastructure\Repositories;

use App\Games\Domain\Models\Game;
use App\Helpers\AssertHelper;
use App\Shared\Infrastructure\Repositories\RepositoryTrait;
use Illuminate\Database\Eloquent\Collection;

final readonly class GameRepository implements GameRepositoryInterface
{
    /** @use RepositoryTrait<Game> */
    use RepositoryTrait;

    public function __construct(Game $model)
    {
        $this->model = $model;
    }

    public function getGameWithCategoriesAndPlayableItemsById(string $id): Game
    {
        $game = $this->queryWhereAttribute('id', $id)
            ->with(
                [
                    'categories',
                    'playableItems',
                ]
            )->first();

        return AssertHelper::isGameNotNull($game);
    }

    /** @return Collection<int, Game> */
    public function getAllGamesWithoutRequestedCategory(string $userId, string $categoryId): Collection
    {
        return $this->queryWhereUserId($userId)->doesntHave(relation: 'categories', callback: function ($query) use ($categoryId) {
            $query->where('categories.id', $categoryId);
        })->get();
    }
}
