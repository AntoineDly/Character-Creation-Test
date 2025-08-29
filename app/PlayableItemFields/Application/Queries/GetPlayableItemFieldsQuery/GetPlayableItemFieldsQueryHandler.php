<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Application\Queries\GetPlayableItemFieldsQuery;

use App\PlayableItemFields\Domain\Dtos\PlayableItemFieldDto\PlayableItemFieldDto;
use App\PlayableItemFields\Domain\Dtos\PlayableItemFieldDto\PlayableItemFieldDtoCollection;
use App\PlayableItemFields\Domain\Models\PlayableItemField;
use App\PlayableItemFields\Domain\Services\PlayableItemFieldQueriesService;
use App\PlayableItemFields\Infrastructure\Repositories\PlayableItemFieldRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationBuilderHelper;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDto;

final readonly class GetPlayableItemFieldsQueryHandler implements QueryHandlerInterface
{
    /** @use DtosWithPaginationBuilderHelper<PlayableItemField, PlayableItemFieldDto> */
    use DtosWithPaginationBuilderHelper;

    public function __construct(
        private PlayableItemFieldRepositoryInterface $playableItemFieldRepository,
        private PlayableItemFieldQueriesService $playableItemFieldQueriesService,
    ) {
    }

    /** @return DtosWithPaginationDto<PlayableItemFieldDto> */
    public function handle(QueryInterface $query): DtosWithPaginationDto
    {
        if (! $query instanceof GetPlayableItemFieldsQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetPlayableItemFieldsQuery::class]);
        }
        $playableItemFields = $this->playableItemFieldRepository->index($query->sortedAndPaginatedDto);

        $dtoCollection = PlayableItemFieldDtoCollection::fromMap(fn (?PlayableItemField $playableItemField) => $this->playableItemFieldQueriesService->getPlayableItemFieldDtoFromModel(playableItemField: $playableItemField), $playableItemFields->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator($dtoCollection->getReadonlyCollection(), $playableItemFields);
    }
}
