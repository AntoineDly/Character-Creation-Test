<?php

declare(strict_types=1);

namespace App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto;

use App\Shared\Domain\Dtos\DtoCollectionInterface;
use App\Shared\Domain\Dtos\DtoInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of Model
 * @template TDto of DtoInterface
 */
trait DtosWithPaginationBuilderHelper
{
    /**
     * @param  DtoCollectionInterface<TDto>  $dtoCollection
     * @param  LengthAwarePaginator<TModel>  $lengthAwarePaginator
     * @return DtosWithPaginationDto<TDto>
     */
    private function getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator(DtoCollectionInterface $dtoCollection, LengthAwarePaginator $lengthAwarePaginator): DtosWithPaginationDto
    {
        $builder = DtosWithPaginationDtoBuilder::createFromDtoCollection($dtoCollection);
        $builder = $this->getBuilderWithDataFromLengthAwarePaginator($lengthAwarePaginator, $builder);

        return $builder->build();
    }

    /**
     * @param  DtosWithPaginationDtoBuilder<TDto>  $builder
     * @param  LengthAwarePaginator<TModel>  $lengthAwarePaginator
     * @return DtosWithPaginationDtoBuilder<TDto>
     */
    private function getBuilderWithDataFromLengthAwarePaginator(LengthAwarePaginator $lengthAwarePaginator, DtosWithPaginationDtoBuilder $builder): DtosWithPaginationDtoBuilder
    {
        $builder->setCurrentPage($lengthAwarePaginator->currentPage());
        $builder->setTotal($lengthAwarePaginator->total());
        $builder->setPerPage($lengthAwarePaginator->perPage());

        if ($lengthAwarePaginator->currentPage() > 1) {
            $builder->setFirstPage(1);
            $builder->setPreviousPage($lengthAwarePaginator->currentPage() - 1);
        }

        if ($lengthAwarePaginator->currentPage() < $lengthAwarePaginator->lastPage()) {
            $builder->setNextPage($lengthAwarePaginator->currentPage() + 1);
            $builder->setLastPage($lengthAwarePaginator->lastPage());
        }

        return $builder;
    }
}
