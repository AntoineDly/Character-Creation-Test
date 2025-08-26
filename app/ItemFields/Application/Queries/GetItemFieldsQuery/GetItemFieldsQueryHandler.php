<?php

declare(strict_types=1);

namespace App\ItemFields\Application\Queries\GetItemFieldsQuery;

use App\ItemFields\Domain\Dtos\ItemFieldDto\ItemFieldDtoCollection;
use App\ItemFields\Domain\Models\ItemField;
use App\ItemFields\Domain\Services\ItemFieldQueriesService;
use App\ItemFields\Infrastructure\Repositories\ItemFieldRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationBuilderHelper;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDto;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDtoBuilder;

final readonly class GetItemFieldsQueryHandler implements QueryHandlerInterface
{
    /** @use DtosWithPaginationBuilderHelper<ItemField> */
    use DtosWithPaginationBuilderHelper;

    /** @param DtosWithPaginationDtoBuilder<ItemField> $dtosWithPaginationDtoBuilder */
    public function __construct(
        private ItemFieldRepositoryInterface $itemFieldRepository,
        private ItemFieldQueriesService $itemFieldQueriesService,
        DtosWithPaginationDtoBuilder $dtosWithPaginationDtoBuilder
    ) {
        $this->dtosWithPaginationDtoBuilder = $dtosWithPaginationDtoBuilder;
    }

    public function handle(QueryInterface $query): DtosWithPaginationDto
    {
        if (! $query instanceof GetItemFieldsQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetItemFieldsQuery::class]);
        }
        $itemFields = $this->itemFieldRepository->index($query->sortedAndPaginatedDto);

        $dtos = ItemFieldDtoCollection::fromMap(fn (?ItemField $itemField) => $this->itemFieldQueriesService->getItemFieldDtoFromModel(itemField: $itemField), $itemFields->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator($dtos, $itemFields);
    }
}
