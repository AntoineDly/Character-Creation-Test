<?php

declare(strict_types=1);

namespace App\Characters\Application\Queries\GetCharacterQuery;

use App\Shared\Application\Queries\QueryInterface;

final readonly class GetCharacterQuery implements QueryInterface
{
    public function __construct(
        public string $characterId,
    ) {
    }
}
