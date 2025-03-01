<?php

declare(strict_types=1);

namespace App\Games\Repositories;

use App\Games\Models\Game;
use App\Helpers\AssertHelper;
use App\Shared\Repositories\AbstractRepository\AbstractRepository;

final readonly class GameRepository extends AbstractRepository implements GameRepositoryInterface
{
    public function __construct(Game $model)
    {
        parent::__construct($model);
    }

    public function getGameWithCategoriesAndItemsById(string $id): Game
    {
        $game = $this->model->query()->where('id', $id)
            ->with(
                [
                    'categories',
                    'items',
                ]
            )->first();

        return AssertHelper::isGame($game);
    }
}
