<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Application\Queries\GetPlayableItemFieldQuery;

use App\Shared\Application\Queries\QueryInterface;

final readonly class GetPlayableItemFieldQuery implements QueryInterface
{
    public function __construct(
        public string $playableItemFieldId
    ) {
    }
}
