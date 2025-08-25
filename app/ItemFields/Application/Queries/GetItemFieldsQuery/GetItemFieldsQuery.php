<?php

declare(strict_types=1);

namespace App\ItemFields\Application\Queries\GetItemFieldsQuery;

use App\Shared\Application\Queries\QueryInterface;
use App\Shared\Domain\SortAndPagination\Dtos\SortedAndPaginatedDto\SortedAndPaginatedDto;

final readonly class GetItemFieldsQuery implements QueryInterface
{
    public function __construct(
        public SortedAndPaginatedDto $sortedAndPaginatedDto,
    ) {
    }
}
