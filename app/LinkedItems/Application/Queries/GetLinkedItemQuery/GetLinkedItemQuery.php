<?php

declare(strict_types=1);

namespace App\LinkedItems\Application\Queries\GetLinkedItemQuery;

use App\Shared\Application\Queries\QueryInterface;

final readonly class GetLinkedItemQuery implements QueryInterface
{
    public function __construct(
        public string $linkedItemId,
    ) {
    }
}
