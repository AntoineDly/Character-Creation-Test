<?php

declare(strict_types=1);

namespace App\Shared\Traits;

use App\Shared\Builders\DtosWithPaginationDtoBuilder;
use App\Shared\Dtos\DtoInterface;
use App\Shared\Dtos\DtosWithPaginationDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

trait DtosWithPaginationBuilderHelper
{
    private readonly DtosWithPaginationDtoBuilder $dtosWithPaginationDtoBuilder;

    /**
     * @param  DtoInterface[]  $dtos
     * @param  LengthAwarePaginator<Model>  $lengthAwarePaginator
     */
    private function getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator(array $dtos, LengthAwarePaginator $lengthAwarePaginator): DtosWithPaginationDto
    {
        return $this->dtosWithPaginationDtoBuilder
            ->setDtos($dtos)
            ->setDataFromLengthAwarePaginator($lengthAwarePaginator)
            ->build();
    }
}
