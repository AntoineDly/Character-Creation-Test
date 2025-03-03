<?php

declare(strict_types=1);

namespace App\Games\Repositories;

use App\Games\Models\Game;
use App\Shared\Repositories\AbstractRepository\AbstractRepositoryInterface;

interface GameRepositoryInterface extends AbstractRepositoryInterface
{
    public function getGameWithCategoriesAndPlayableItemsById(string $id): Game;
}
