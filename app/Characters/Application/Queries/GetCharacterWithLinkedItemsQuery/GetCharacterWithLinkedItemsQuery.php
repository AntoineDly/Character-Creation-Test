<?php

declare(strict_types=1);

namespace App\Characters\Application\Queries\GetCharacterWithLinkedItemsQuery;

use App\Shared\Application\Queries\QueryInterface;

final readonly class GetCharacterWithLinkedItemsQuery implements QueryInterface
{
    public function __construct(
        public string $characterId,
    ) {
    }
}
