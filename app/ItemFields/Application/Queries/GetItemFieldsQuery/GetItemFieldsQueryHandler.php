<?php

declare(strict_types=1);

namespace App\ItemFields\Application\Queries\GetItemFieldsQuery;

use App\Fields\Domain\Dtos\FieldDto\FieldDto;
use App\Fields\Domain\Services\FieldServices;
use App\ItemFields\Domain\Models\ItemField;
use App\ItemFields\Infrastructure\Repositories\ItemFieldRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationBuilderHelper;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDto;

final readonly class GetItemFieldsQueryHandler implements QueryHandlerInterface
{
    /** @use DtosWithPaginationBuilderHelper<ItemField, FieldDto> */
    use DtosWithPaginationBuilderHelper;

    public function __construct(
        private ItemFieldRepositoryInterface $itemFieldRepository,
        private FieldServices $fieldServices,
    ) {
    }

    /** @return DtosWithPaginationDto<FieldDto> */
    public function handle(QueryInterface $query): DtosWithPaginationDto
    {
        if (! $query instanceof GetItemFieldsQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetItemFieldsQuery::class]);
        }
        $itemFields = $this->itemFieldRepository->index($query->sortedAndPaginatedDto);

        $dtoCollection = $this->fieldServices->getFieldDtoCollectionFromFieldInterfaces($itemFields->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator($dtoCollection->getReadonlyCollection(), $itemFields);
    }
}
