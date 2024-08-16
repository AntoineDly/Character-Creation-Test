<?php

declare(strict_types=1);

namespace App\Components\Repositories;

use App\Shared\Repositories\AbstractRepository\AbstractRepositoryInterface;

interface ComponentRepositoryInterface extends AbstractRepositoryInterface
{
    public function associateGame(string $componentId, string $gameId): void;

    public function associateCategory(string $componentId, string $categoryId): void;

    public function associateCharacter(string $componentId, string $characterId): void;
}
