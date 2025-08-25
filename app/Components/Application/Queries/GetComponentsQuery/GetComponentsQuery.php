<?php

declare(strict_types=1);

namespace App\Components\Application\Queries\GetComponentsQuery;

use App\Shared\Application\Queries\QueryInterface;
use App\Shared\Domain\SortAndPagination\Dtos\SortedAndPaginatedDto\SortedAndPaginatedDto;

final readonly class GetComponentsQuery implements QueryInterface
{
    public function __construct(
        public SortedAndPaginatedDto $sortedAndPaginatedDto,
    ) {
    }
}
