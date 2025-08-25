<?php

declare(strict_types=1);

namespace App\Categories\Application\Queries\GetAllCategoriesWithoutRequestedGameQuery;

use App\Shared\Application\Queries\QueryInterface;

final readonly class GetAllCategoriesWithoutRequestedGameQuery implements QueryInterface
{
    public function __construct(
        public string $userId,
        public string $gameId,
    ) {
    }
}
