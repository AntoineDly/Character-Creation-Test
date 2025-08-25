<?php

declare(strict_types=1);

namespace App\Parameters\Application\Queries\GetParametersQuery;

use App\Shared\Application\Queries\QueryInterface;
use App\Shared\Domain\SortAndPagination\Dtos\SortedAndPaginatedDto\SortedAndPaginatedDto;

final readonly class GetParametersQuery implements QueryInterface
{
    public function __construct(
        public SortedAndPaginatedDto $sortedAndPaginatedDto,
    ) {
    }
}
