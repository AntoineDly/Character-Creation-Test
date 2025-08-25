<?php

declare(strict_types=1);

namespace App\Characters\Application\Queries\GetCharacterWithGameQuery;

use App\Shared\Application\Queries\QueryInterface;

final readonly class GetCharacterWithGameQuery implements QueryInterface
{
    public function __construct(
        public string $characterId,
    ) {
    }
}
