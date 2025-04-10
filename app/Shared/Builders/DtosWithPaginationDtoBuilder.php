<?php

declare(strict_types=1);

namespace App\Shared\Builders;

use App\Shared\Dtos\DtoInterface;
use App\Shared\Dtos\DtosWithPaginationDto;
use App\Shared\Dtos\PaginationDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

final class DtosWithPaginationDtoBuilder implements BuilderInterface
{
    /** @var DtoInterface[] */
    public array $dtos = [];

    public int $currentPage = 1;

    public int $perPage = 15;

    public int $total = 0;

    public ?int $firstPage = null;

    public ?int $previousPage = null;

    public ?int $nextPage = null;

    public ?int $lastPage = null;

    /** @param DtoInterface[] $dtos */
    public function setDtos(array $dtos): self
    {
        $this->dtos = $dtos;

        return $this;
    }

    public function setCurrentPage(int $currentPage): self
    {
        $this->currentPage = $currentPage;

        return $this;
    }

    public function setPerPage(int $perPage): self
    {
        $this->perPage = $perPage;

        return $this;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function setFirstPage(?int $firstPage): self
    {
        $this->firstPage = $firstPage;

        return $this;
    }

    public function setPreviousPage(?int $previousPage): self
    {
        $this->previousPage = $previousPage;

        return $this;
    }

    public function setNextPage(?int $nextPage): self
    {
        $this->nextPage = $nextPage;

        return $this;
    }

    public function setLastPage(?int $lastPage): self
    {
        $this->lastPage = $lastPage;

        return $this;
    }

    /**
     * @param  LengthAwarePaginator<Model>  $lengthAwarePaginator
     */
    public function setDataFromLengthAwarePaginator(LengthAwarePaginator $lengthAwarePaginator): self
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
