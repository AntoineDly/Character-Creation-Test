<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Queries;

use App\LinkedItemFields\Repositories\LinkedItemFieldRepositoryInterface;
use App\LinkedItemFields\Services\LinkedItemFieldQueriesService;
use App\Shared\Builders\DtosWithPaginationDtoBuilder;
use App\Shared\Dtos\DtosWithPaginationDto;
use App\Shared\Dtos\SortedAndPaginatedDto;
use App\Shared\Queries\QueryInterface;
use App\Shared\Traits\DtosWithPaginationBuilderHelper;
use Illuminate\Database\Eloquent\Model;

final readonly class GetLinkedItemFieldsQuery implements QueryInterface
{
    use DtosWithPaginationBuilderHelper;

    public function __construct(
        private LinkedItemFieldRepositoryInterface $linkedItemFieldRepository,
        private LinkedItemFieldQueriesService $linkedItemFieldQueriesService,
        private SortedAndPaginatedDto $sortedAndPaginatedDto,
        DtosWithPaginationDtoBuilder $dtosWithPaginationDtoBuilder,
    ) {
        $this->dtosWithPaginationDtoBuilder = $dtosWithPaginationDtoBuilder;
    }

    public function get(): DtosWithPaginationDto
    {
        $fields = $this->linkedItemFieldRepository->index($this->sortedAndPaginatedDto);

        $dtos = array_map(fn (?Model $linkedItemField) => $this->linkedItemFieldQueriesService->getLinkedFieldDtoFromModel(linkedItemField: $linkedItemField), $fields->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator($dtos, $fields);
    }
}
