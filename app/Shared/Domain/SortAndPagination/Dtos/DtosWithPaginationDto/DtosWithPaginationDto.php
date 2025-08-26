<?php

declare(strict_types=1);

namespace App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto;

use App\Shared\Domain\Dtos\DtoCollectionInterface;
use App\Shared\Domain\Dtos\DtoInterface;
use App\Shared\Domain\SortAndPagination\Dtos\PaginationDto\PaginationDto;

/**
 * @template TDto of DtoInterface
 */
final readonly class DtosWithPaginationDto implements DtoInterface
{
    /** @param DtoCollectionInterface<TDto> $dtoCollection */
    public function __construct(
        public DtoCollectionInterface $dtoCollection,
        public PaginationDto $paginationDto,
    ) {
    }
}
