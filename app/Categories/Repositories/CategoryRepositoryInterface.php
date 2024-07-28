<?php

declare(strict_types=1);

namespace App\Categories\Repositories;

use App\Base\Repositories\AbstractRepository\AbstractRepositoryInterface;

interface CategoryRepositoryInterface extends AbstractRepositoryInterface
{
    public function associateGame(string $categoryId, string $gameId): void;
}
