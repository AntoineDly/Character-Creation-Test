<?php

declare(strict_types=1);

namespace App\Games\Application\Queries\GetAllGamesQuery;

use App\Shared\Application\Queries\QueryInterface;

final readonly class GetAllGamesQuery implements QueryInterface
{
    public function __construct(
        public string $userId
    ) {
    }
}
