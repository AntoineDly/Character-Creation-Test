<?php

declare(strict_types=1);

namespace App\Shared\Domain\SortAndPagination\Dtos\PaginationDto;

use App\Shared\Domain\Dtos\DtoInterface;

final readonly class PaginationDto implements DtoInterface
{
    public function __construct(
        public int $currentPage,
        public int $perPage,
        public int $total,
        public ?int $firstPage,
        public ?int $previousPage,
        public ?int $nextPage,
        public ?int $lastPage,
    ) {
    }
}
