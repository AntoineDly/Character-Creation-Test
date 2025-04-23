<?php

declare(strict_types=1);

namespace App\Games\Repositories;

use App\Games\Models\Game;
use App\Shared\Repositories\RepositoryInterface;

interface GameRepositoryInterface extends RepositoryInterface
{
    public function getGameWithCategoriesAndPlayableItemsById(string $id): Game;
}
