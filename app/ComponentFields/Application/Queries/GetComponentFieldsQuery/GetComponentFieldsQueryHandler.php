<?php

declare(strict_types=1);

namespace App\ComponentFields\Application\Queries\GetComponentFieldsQuery;

use App\ComponentFields\Domain\Models\ComponentField;
use App\ComponentFields\Infrastructure\Repositories\ComponentFieldRepositoryInterface;
use App\Fields\Domain\Dtos\FieldDto\FieldDto;
use App\Fields\Domain\Services\FieldServices;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationBuilderHelper;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDto;

final readonly class GetComponentFieldsQueryHandler implements QueryHandlerInterface
{
    /** @use DtosWithPaginationBuilderHelper<ComponentField, FieldDto> */
    use DtosWithPaginationBuilderHelper;

    public function __construct(
        private ComponentFieldRepositoryInterface $componentFieldRepository,
        private FieldServices $fieldServices,
    ) {
    }

    /** @return DtosWithPaginationDto<FieldDto> */
    public function handle(QueryInterface $query): DtosWithPaginationDto
    {
        if (! $query instanceof GetComponentFieldsQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetComponentFieldsQuery::class]);
        }
        $componentFields = $this->componentFieldRepository->allWithParameters($query->sortedAndPaginatedDto);

        $dtoCollection = $this->fieldServices->getFieldDtoCollectionFromFieldInterfaces($componentFields->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator($dtoCollection->getReadonlyCollection(), $componentFields);
    }
}
