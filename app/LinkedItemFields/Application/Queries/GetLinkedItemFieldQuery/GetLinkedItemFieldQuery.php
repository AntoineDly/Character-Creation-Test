<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Application\Queries\GetLinkedItemFieldQuery;

use App\Shared\Application\Queries\QueryInterface;

final readonly class GetLinkedItemFieldQuery implements QueryInterface
{
    public function __construct(
        public string $linkedItemFieldId
    ) {
    }
}
