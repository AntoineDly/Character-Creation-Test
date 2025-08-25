<?php

declare(strict_types=1);

namespace App\Games\Application\Queries\GetGameWithCategoriesAndPlayableItemsQuery;

use App\Shared\Application\Queries\QueryInterface;

final readonly class GetGameWithCategoriesAndPlayableItemsQuery implements QueryInterface
{
    public function __construct(
        public string $gameId,
    ) {
    }
}
