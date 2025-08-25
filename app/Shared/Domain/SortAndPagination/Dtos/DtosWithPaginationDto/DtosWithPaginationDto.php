<?php

declare(strict_types=1);

namespace App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto;

use App\Shared\Domain\Dtos\DtoCollectionInterface;
use App\Shared\Domain\Dtos\DtoInterface;
use App\Shared\Domain\SortAndPagination\Dtos\PaginationDto\PaginationDto;
use Illuminate\Database\Eloquent\Model;

final readonly class DtosWithPaginationDto implements DtoInterface
{
    /** @param DtoInterface[]|DtoCollectionInterface $dtos */
    public function __construct(
        public array|DtoCollectionInterface $dtos,
        public PaginationDto $paginationDto,
    ) {
    }
}
