<?php

declare(strict_types=1);

namespace App\Shared\SortAndPagination\Dtos;

use App\Shared\Collection\DtoCollectionInterface;
use App\Shared\Dtos\DtoInterface;
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
