<?php

declare(strict_types=1);

namespace App\Items\Repositories;

use App\Shared\Repositories\AbstractRepository\AbstractRepositoryInterface;

interface ItemRepositoryInterface extends AbstractRepositoryInterface
{
    public function associateGame(string $itemId, string $gameId): void;

    public function associateCategory(string $itemId, string $categoryId): void;

    public function associateCharacter(string $itemId, string $characterId): void;
}
