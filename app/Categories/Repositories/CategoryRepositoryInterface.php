<?php

declare(strict_types=1);

namespace App\Categories\Repositories;

use App\Shared\Repositories\RepositoryInterface;

interface CategoryRepositoryInterface extends RepositoryInterface
{
    public function associateGame(string $categoryId, string $gameId): void;
}
