<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Application\Queries\GetLinkedItemFieldsQuery;

use App\Fields\Domain\Dtos\FieldDto\FieldDto;
use App\Fields\Domain\Services\FieldServices;
use App\LinkedItemFields\Domain\Models\LinkedItemField;
use App\LinkedItemFields\Infrastructure\Repositories\LinkedItemFieldRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationBuilderHelper;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDto;

final readonly class GetLinkedItemFieldsQueryHandler implements QueryHandlerInterface
{
    /** @use DtosWithPaginationBuilderHelper<LinkedItemField, FieldDto> */
    use DtosWithPaginationBuilderHelper;

    public function __construct(
        private LinkedItemFieldRepositoryInterface $linkedItemFieldRepository,
        private FieldServices $fieldServices,
    ) {
    }

    /** @return DtosWithPaginationDto<FieldDto> */
    public function handle(QueryInterface $query): DtosWithPaginationDto
    {
        if (! $query instanceof GetLinkedItemFieldsQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetLinkedItemFieldsQuery::class]);
        }
        $linkedItemFields = $this->linkedItemFieldRepository->index($query->sortedAndPaginatedDto);

        $dtoCollection = $this->fieldServices->getFieldDtoCollectionFromFieldInterfaces($linkedItemFields->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator($dtoCollection->getReadonlyCollection(), $linkedItemFields);
    }
}
