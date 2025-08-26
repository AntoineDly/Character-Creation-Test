<?php

declare(strict_types=1);

namespace App\Components\Application\Queries\GetComponentsQuery;

use App\Components\Domain\Dtos\ComponentDto\ComponentDtoCollection;
use App\Components\Domain\Models\Component;
use App\Components\Domain\Services\ComponentQueriesService;
use App\Components\Infrastructure\Repositories\ComponentRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationBuilderHelper;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDto;

final readonly class GetComponentsQueryHandler implements QueryHandlerInterface
{
    /** @use DtosWithPaginationBuilderHelper<Component> */
    use DtosWithPaginationBuilderHelper;

    public function __construct(
        private ComponentRepositoryInterface $componentRepository,
        private ComponentQueriesService $componentQueriesService,
    ) {
    }

    public function handle(QueryInterface $query): DtosWithPaginationDto
    {
        if (! $query instanceof GetComponentsQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetComponentsQuery::class]);
        }
        $components = $this->componentRepository->index($query->sortedAndPaginatedDto);

        $dtoCollection = ComponentDtoCollection::fromMap(fn (?Component $component) => $this->componentQueriesService->getComponentDtoFromModel(component: $component), $components->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator($dtoCollection, $components);
    }
}
