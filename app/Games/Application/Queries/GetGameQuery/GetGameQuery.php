<?php

declare(strict_types=1);

namespace App\Games\Application\Queries\GetGameQuery;

use App\Shared\Application\Queries\QueryInterface;

final readonly class GetGameQuery implements QueryInterface
{
    public function __construct(
        public string $gameId,
    ) {
    }
}
