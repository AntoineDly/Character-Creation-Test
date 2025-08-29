<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Application\Queries\GetLinkedItemFieldsQuery;

use App\LinkedItemFields\Domain\Dtos\LinkedItemFieldDto\LinkedItemFieldDto;
use App\LinkedItemFields\Domain\Dtos\LinkedItemFieldDto\LinkedItemFieldDtoCollection;
use App\LinkedItemFields\Domain\Models\LinkedItemField;
use App\LinkedItemFields\Domain\Services\LinkedItemFieldQueriesService;
use App\LinkedItemFields\Infrastructure\Repositories\LinkedItemFieldRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationBuilderHelper;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDto;

final readonly class GetLinkedItemFieldsQueryHandler implements QueryHandlerInterface
{
    /** @use DtosWithPaginationBuilderHelper<LinkedItemField, LinkedItemFieldDto> */
    use DtosWithPaginationBuilderHelper;

    public function __construct(
        private LinkedItemFieldRepositoryInterface $linkedItemFieldRepository,
        private LinkedItemFieldQueriesService $linkedItemFieldQueriesService,
    ) {
    }

    /** @return DtosWithPaginationDto<LinkedItemFieldDto> */
    public function handle(QueryInterface $query): DtosWithPaginationDto
    {
        if (! $query instanceof GetLinkedItemFieldsQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetLinkedItemFieldsQuery::class]);
        }
        $fields = $this->linkedItemFieldRepository->index($query->sortedAndPaginatedDto);

        $dtoCollection = LinkedItemFieldDtoCollection::fromMap(fn (?LinkedItemField $linkedItemField) => $this->linkedItemFieldQueriesService->getLinkedFieldDtoFromModel(linkedItemField: $linkedItemField), $fields->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator($dtoCollection->getReadonlyCollection(), $fields);
    }
}
