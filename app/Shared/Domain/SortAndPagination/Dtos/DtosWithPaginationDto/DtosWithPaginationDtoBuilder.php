<?php

declare(strict_types=1);

namespace App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto;

use App\Shared\Domain\Collection\Readonly\ReadonlyCollectionInterface;
use App\Shared\Domain\Dtos\BuilderInterface;
use App\Shared\Domain\Dtos\DtoInterface;
use App\Shared\Domain\SortAndPagination\Dtos\PaginationDto\PaginationDto;

/**
 * @template-covariant TDto of DtoInterface
 */
final class DtosWithPaginationDtoBuilder implements BuilderInterface
{
    public int $currentPage = 1;

    public int $perPage = 15;

    public int $total = 0;

    public ?int $firstPage = null;

    public ?int $previousPage = null;

    public ?int $nextPage = null;

    public ?int $lastPage = null;

    /** @param ReadonlyCollectionInterface<TDto> $readonlyCollection */
    public static function createFromReadonlyCollection(ReadonlyCollectionInterface $readonlyCollection): static
    {
        return new self($readonlyCollection);
    }

    /** @param ReadonlyCollectionInterface<TDto> $readonlyCollection */
    public function __construct(public ReadonlyCollectionInterface $readonlyCollection)
    {
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

    /** @return DtosWithPaginationDto<TDto> */
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
            dtos: $this->readonlyCollection,
            paginationDto: $paginationDto,
        );

        $this->readonlyCollection = $this->readonlyCollection->createEmpty();
        $this->currentPage = 1;
        $this->perPage = 15;
        $this->total = 0;
        $this->firstPage = $this->previousPage = $this->nextPage = $this->lastPage = null;

        return $dto;
    }
}
