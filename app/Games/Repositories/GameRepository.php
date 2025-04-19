<?php

declare(strict_types=1);

namespace App\Games\Repositories;

use App\Games\Models\Game;
use App\Helpers\AssertHelper;
use App\Shared\Repositories\AbstractRepository\RepositoryTrait;

final readonly class GameRepository implements GameRepositoryInterface
{
    use RepositoryTrait;

    public function __construct(Game $model)
    {
        $this->model = $model;
    }

    public function getGameWithCategoriesAndPlayableItemsById(string $id): Game
    {
        $game = $this->model->query()->where('id', $id)
            ->with(
                [
                    'categories',
                    'playableItems',
                ]
            )->first();

        return AssertHelper::isGame($game);
    }
}
