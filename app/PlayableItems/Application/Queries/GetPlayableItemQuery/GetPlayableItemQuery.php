<?php

declare(strict_types=1);

namespace App\PlayableItems\Application\Queries\GetPlayableItemQuery;

use App\Shared\Application\Queries\QueryInterface;

final readonly class GetPlayableItemQuery implements QueryInterface
{
    public function __construct(
        public string $playableItemId,
    ) {
    }
}
