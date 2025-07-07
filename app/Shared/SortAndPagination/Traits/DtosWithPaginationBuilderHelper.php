<?php

declare(strict_types=1);

namespace App\Shared\SortAndPagination\Traits;

use App\Shared\Collection\DtoCollectionInterface;
use App\Shared\Dtos\DtoInterface;
use App\Shared\SortAndPagination\Builders\DtosWithPaginationDtoBuilder;
use App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of Model
 */
trait DtosWithPaginationBuilderHelper
{
    /** @var DtosWithPaginationDtoBuilder<TModel> */
    private readonly DtosWithPaginationDtoBuilder $dtosWithPaginationDtoBuilder;

    /**
     * @param  DtoInterface[]|DtoCollectionInterface<TModel>  $dtos
     * @param  LengthAwarePaginator<TModel>  $lengthAwarePaginator
     * @return DtosWithPaginationDto<TModel>
     */
    private function getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator(array|DtoCollectionInterface $dtos, LengthAwarePaginator $lengthAwarePaginator): DtosWithPaginationDto
    {
        return $this->dtosWithPaginationDtoBuilder
            ->setDtos($dtos)
            ->setDataFromLengthAwarePaginator($lengthAwarePaginator)
            ->build();
    }
}
