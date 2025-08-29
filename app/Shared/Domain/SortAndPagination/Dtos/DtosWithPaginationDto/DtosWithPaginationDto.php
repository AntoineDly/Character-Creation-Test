<?php

declare(strict_types=1);

namespace App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto;

use App\Shared\Domain\Collection\Readonly\ReadonlyCollectionInterface;
use App\Shared\Domain\Dtos\DtoInterface;
use App\Shared\Domain\SortAndPagination\Dtos\PaginationDto\PaginationDto;

/**
 * @template-covariant TDto of DtoInterface
 */
final readonly class DtosWithPaginationDto implements DtoInterface
{
    /** @param ReadonlyCollectionInterface<TDto> $dtos */
    public function __construct(
        public ReadonlyCollectionInterface $dtos,
        public PaginationDto $paginationDto,
    ) {
    }
}
