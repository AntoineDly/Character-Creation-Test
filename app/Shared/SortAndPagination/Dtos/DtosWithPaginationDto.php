<?php

declare(strict_types=1);

namespace App\Shared\SortAndPagination\Dtos;

use App\Shared\Dtos\DtoInterface;

final readonly class DtosWithPaginationDto implements DtoInterface
{
    /** @param DtoInterface[] $dtos */
    public function __construct(
        public array $dtos,
        public PaginationDto $paginationDto,
    ) {
    }
}
