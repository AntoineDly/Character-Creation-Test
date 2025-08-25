<?php

declare(strict_types=1);

namespace App\Items\Application\Queries\GetItemsQuery;

use App\Shared\Application\Queries\QueryInterface;
use App\Shared\Domain\SortAndPagination\Dtos\SortedAndPaginatedDto\SortedAndPaginatedDto;

final readonly class GetItemsQuery implements QueryInterface
{
    public function __construct(
        public SortedAndPaginatedDto $sortedAndPaginatedDto,
    ) {
    }
}
