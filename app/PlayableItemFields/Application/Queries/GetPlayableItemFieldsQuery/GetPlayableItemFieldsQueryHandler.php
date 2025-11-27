<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Application\Queries\GetPlayableItemFieldsQuery;

use App\Fields\Domain\Dtos\FieldDto\FieldDto;
use App\Fields\Domain\Services\FieldServices;
use App\PlayableItemFields\Domain\Models\PlayableItemField;
use App\PlayableItemFields\Infrastructure\Repositories\PlayableItemFieldRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationBuilderHelper;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDto;

final readonly class GetPlayableItemFieldsQueryHandler implements QueryHandlerInterface
{
    /** @use DtosWithPaginationBuilderHelper<PlayableItemField, FieldDto> */
    use DtosWithPaginationBuilderHelper;

    public function __construct(
        private PlayableItemFieldRepositoryInterface $playableItemFieldRepository,
        private FieldServices $fieldServices,
    ) {
    }

    /** @return DtosWithPaginationDto<FieldDto> */
    public function handle(QueryInterface $query): DtosWithPaginationDto
    {
        if (! $query instanceof GetPlayableItemFieldsQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetPlayableItemFieldsQuery::class]);
        }
        $playableItemFields = $this->playableItemFieldRepository->index($query->sortedAndPaginatedDto);

        $dtoCollection = $this->fieldServices->getFieldDtoCollectionFromFieldInterfaces($playableItemFields->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator($dtoCollection->getReadonlyCollection(), $playableItemFields);
    }
}
