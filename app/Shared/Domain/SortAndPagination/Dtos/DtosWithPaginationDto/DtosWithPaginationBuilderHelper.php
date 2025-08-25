<?php

declare(strict_types=1);

namespace App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto;

use App\Shared\Domain\Dtos\DtoCollectionInterface;
use App\Shared\Domain\Dtos\DtoInterface;
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
     * @param  LengthAwarePaginator<TModel>  $lengthAwarePaginator
     */
    private function getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator(DtoCollectionInterface $dtos, LengthAwarePaginator $lengthAwarePaginator): DtosWithPaginationDto
    {
        return $this->dtosWithPaginationDtoBuilder
            ->setDtos($dtos)
            ->setDataFromLengthAwarePaginator($lengthAwarePaginator)
            ->build();
    }
}
