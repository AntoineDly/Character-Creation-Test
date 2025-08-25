<?php

declare(strict_types=1);

namespace App\ItemFields\Application\Queries\GetItemFieldsQuery;

use App\ItemFields\Domain\Dtos\ItemFieldDto\ItemFieldDto;
use App\ItemFields\Domain\Models\ItemField;
use App\ItemFields\Domain\Services\ItemFieldQueriesService;
use App\ItemFields\Infrastructure\Repositories\ItemFieldRepositoryInterface;
use App\Shared\Application\Queries\QueryInterface;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationBuilderHelper;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDto;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDtoBuilder;
use App\Shared\Domain\SortAndPagination\Dtos\SortedAndPaginatedDto\SortedAndPaginatedDto;

final readonly class GetItemFieldsQuery implements QueryInterface
{
    /** @use DtosWithPaginationBuilderHelper<ItemField> */
    use DtosWithPaginationBuilderHelper;

    /** @param DtosWithPaginationDtoBuilder<ItemField> $dtosWithPaginationDtoBuilder */
    public function __construct(
        private ItemFieldRepositoryInterface $itemFieldRepository,
        private ItemFieldQueriesService $itemFieldQueriesService,
        private SortedAndPaginatedDto $sortedAndPaginatedDto,
        DtosWithPaginationDtoBuilder $dtosWithPaginationDtoBuilder
    ) {
        $this->dtosWithPaginationDtoBuilder = $dtosWithPaginationDtoBuilder;
    }

    public function get(): DtosWithPaginationDto
    {
        $itemFields = $this->itemFieldRepository->index($this->sortedAndPaginatedDto);

        $dtos = array_map(fn (?ItemField $itemField) => $this->itemFieldQueriesService->getItemFieldDtoFromModel(itemField: $itemField), $itemFields->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator($dtos, $itemFields);
    }
}
