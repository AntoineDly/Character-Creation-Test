<?php

declare(strict_types=1);

namespace App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto;

use App\Shared\Dtos\BuilderInterface;
use App\Shared\Dtos\DtoCollectionInterface;
use App\Shared\Dtos\DtoInterface;
use App\Shared\SortAndPagination\Dtos\PaginationDto\PaginationDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of Model
 */
final class DtosWithPaginationDtoBuilder implements BuilderInterface
{
    /** @var DtoInterface[]|DtoCollectionInterface<TModel> */
    public array|DtoCollectionInterface $dtos = [];

    public int $currentPage = 1;

    public int $perPage = 15;

    public int $total = 0;

    public ?int $firstPage = null;

    public ?int $previousPage = null;

    public ?int $nextPage = null;

    public ?int $lastPage = null;

    /** @param DtoInterface[]|DtoCollectionInterface<TModel> $dtos */
    public function setDtos(array|DtoCollectionInterface $dtos): static
    {
        $this->dtos = $dtos;

        return $this;
    }

    public function setCurrentPage(int $currentPage): static
    {
        $this->currentPage = $currentPage;

        return $this;
    }

    public function setPerPage(int $perPage): static
    {
        $this->perPage = $perPage;

        return $this;
    }

    public function setTotal(int $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function setFirstPage(?int $firstPage): static
    {
        $this->firstPage = $firstPage;

        return $this;
    }

    public function setPreviousPage(?int $previousPage): static
    {
        $this->previousPage = $previousPage;

        return $this;
    }

    public function setNextPage(?int $nextPage): static
    {
        $this->nextPage = $nextPage;

        return $this;
    }

    public function setLastPage(?int $lastPage): static
    {
        $this->lastPage = $lastPage;

        return $this;
    }

    /**
     * @param  LengthAwarePaginator<TModel>  $lengthAwarePaginator
     */
    public function setDataFromLengthAwarePaginator(LengthAwarePaginator $lengthAwarePaginator): static
    {
        $this->setCurrentPage($lengthAwarePaginator->currentPage());
        $this->setTotal($lengthAwarePaginator->total());
        $this->setPerPage($lengthAwarePaginator->perPage());

        if ($lengthAwarePaginator->currentPage() > 1) {
            $this->setFirstPage(1);
            $this->setPreviousPage($lengthAwarePaginator->currentPage() - 1);
        }

        if ($lengthAwarePaginator->currentPage() < $lengthAwarePaginator->lastPage()) {
            $this->setNextPage($lengthAwarePaginator->currentPage() + 1);
            $this->setLastPage($lengthAwarePaginator->lastPage());
        }

        return $this;
    }

    /** @return DtosWithPaginationDto<TModel> */
    public function build(): DtosWithPaginationDto
    {
        $paginationDto = new PaginationDto(
            currentPage: $this->currentPage,
            perPage: $this->perPage,
            total: $this->total,
            firstPage: $this->firstPage,
            previousPage: $this->previousPage,
            nextPage: $this->nextPage,
            lastPage: $this->lastPage,
        );

        /** @var DtosWithPaginationDto<TModel> $dto */
        $dto = new DtosWithPaginationDto(
            dtos: $this->dtos,
            paginationDto: $paginationDto,
        );

        $this->dtos = [];
        $this->currentPage = 1;
        $this->perPage = 15;
        $this->total = 0;
        $this->firstPage = $this->previousPage = $this->nextPage = $this->lastPage = null;

        return $dto;
    }
}
