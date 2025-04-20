<?php

declare(strict_types=1);

namespace App\ItemFields\Queries;

use App\ItemFields\Repositories\ItemFieldRepositoryInterface;
use App\ItemFields\Services\ItemFieldQueriesService;
use App\Shared\Queries\QueryInterface;
use App\Shared\SortAndPagination\Builders\DtosWithPaginationDtoBuilder;
use App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto;
use App\Shared\SortAndPagination\Dtos\SortedAndPaginatedDto;
use App\Shared\SortAndPagination\Traits\DtosWithPaginationBuilderHelper;
use Illuminate\Database\Eloquent\Model;

final readonly class GetItemFieldsQuery implements QueryInterface
{
    use DtosWithPaginationBuilderHelper;

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

        $dtos = array_map(fn (?Model $itemField) => $this->itemFieldQueriesService->getItemFieldDtoFromModel(itemField: $itemField), $itemFields->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator($dtos, $itemFields);
    }
}
