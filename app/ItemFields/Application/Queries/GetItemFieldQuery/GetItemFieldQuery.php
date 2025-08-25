<?php

declare(strict_types=1);

namespace App\ItemFields\Application\Queries\GetItemFieldQuery;

use App\Shared\Application\Queries\QueryInterface;

final readonly class GetItemFieldQuery implements QueryInterface
{
    public function __construct(
        public string $itemFieldId
    ) {
    }
}
