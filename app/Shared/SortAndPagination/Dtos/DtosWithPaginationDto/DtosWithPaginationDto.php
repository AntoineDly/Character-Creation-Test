<?php

declare(strict_types=1);

namespace App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto;

use App\Shared\Dtos\DtoCollectionInterface;
use App\Shared\Dtos\DtoInterface;
use App\Shared\SortAndPagination\Dtos\PaginationDto\PaginationDto;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of Model
 */
final readonly class DtosWithPaginationDto implements DtoInterface
{
    /** @param DtoInterface[]|DtoCollectionInterface<TModel> $dtos */
    public function __construct(
        public array|DtoCollectionInterface $dtos,
        public PaginationDto $paginationDto,
    ) {
    }
}
