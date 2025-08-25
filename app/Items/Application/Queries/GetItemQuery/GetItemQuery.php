<?php

declare(strict_types=1);

namespace App\Items\Application\Queries\GetItemQuery;

use App\Shared\Application\Queries\QueryInterface;

final readonly class GetItemQuery implements QueryInterface
{
    public function __construct(
        public string $itemId,
    ) {
    }
}
