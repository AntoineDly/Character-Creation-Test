<?php

declare(strict_types=1);

namespace App\ComponentFields\Application\Queries\GetComponentFieldsQuery;

use App\ComponentFields\Domain\Dtos\ComponentFieldDto\ComponentFieldDto;
use App\ComponentFields\Domain\Dtos\ComponentFieldDto\ComponentFieldDtoCollection;
use App\ComponentFields\Domain\Models\ComponentField;
use App\ComponentFields\Domain\Services\ComponentFieldQueriesService;
use App\ComponentFields\Infrastructure\Repositories\ComponentFieldRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationBuilderHelper;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDto;

final readonly class GetComponentFieldsQueryHandler implements QueryHandlerInterface
{
    /** @use DtosWithPaginationBuilderHelper<ComponentField, ComponentFieldDto> */
    use DtosWithPaginationBuilderHelper;

    public function __construct(
        private ComponentFieldRepositoryInterface $componentFieldRepository,
        private ComponentFieldQueriesService $componentFieldQueriesService,
    ) {
    }

    /** @return DtosWithPaginationDto<ComponentFieldDto> */
    public function handle(QueryInterface $query): DtosWithPaginationDto
    {
        if (! $query instanceof GetComponentFieldsQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetComponentFieldsQuery::class]);
        }
        $componentFields = $this->componentFieldRepository->index($query->sortedAndPaginatedDto);

        $dtoCollection = ComponentFieldDtoCollection::fromMap(fn (?ComponentField $componentField) => $this->componentFieldQueriesService->getComponentFieldDtoFromModel(componentField: $componentField), $componentFields->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator($dtoCollection->getReadonlyCollection(), $componentFields);
    }
}
