<?php

declare(strict_types=1);

namespace App\Shared\Dtos;

final readonly class DtosWithPaginationDto implements DtoInterface
{
    /** @param DtoInterface[] $dtos */
    public function __construct(
        public array $dtos,
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
