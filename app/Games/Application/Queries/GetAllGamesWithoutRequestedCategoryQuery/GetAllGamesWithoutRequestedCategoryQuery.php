<?php

declare(strict_types=1);

namespace App\Games\Application\Queries\GetAllGamesWithoutRequestedCategoryQuery;

use App\Shared\Application\Queries\QueryInterface;

final readonly class GetAllGamesWithoutRequestedCategoryQuery implements QueryInterface
{
    public function __construct(
        public string $userId,
        public string $categoryId,
    ) {
    }
}
