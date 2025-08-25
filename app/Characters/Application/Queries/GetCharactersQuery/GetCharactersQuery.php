<?php

declare(strict_types=1);

namespace App\Characters\Application\Queries\GetCharactersQuery;

use App\Shared\Application\Queries\QueryInterface;
use App\Shared\Domain\SortAndPagination\Dtos\SortedAndPaginatedDto\SortedAndPaginatedDto;

final readonly class GetCharactersQuery implements QueryInterface
{
    public function __construct(
        public SortedAndPaginatedDto $sortedAndPaginatedDto,
    ) {
    }
}
