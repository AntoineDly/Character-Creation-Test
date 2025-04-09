<?php

declare(strict_types=1);

namespace App\Characters\Queries;

use App\Characters\Repositories\CharacterRepositoryInterface;
use App\Characters\Services\CharacterQueriesService;
use App\Shared\Builders\DtosWithPaginationDtoBuilder;
use App\Shared\Dtos\DtosWithPaginationDto;
use App\Shared\Dtos\SortedAndPaginatedDto;
use App\Shared\Queries\QueryInterface;
use App\Shared\Traits\DtosWithPaginationBuilderHelper;
use Illuminate\Database\Eloquent\Model;

final readonly class GetCharactersQuery implements QueryInterface
{
    use DtosWithPaginationBuilderHelper;

    public function __construct(
        private CharacterRepositoryInterface $characterRepository,
        private CharacterQueriesService $characterQueriesService,
        private SortedAndPaginatedDto $sortedAndPaginatedDto,
        DtosWithPaginationDtoBuilder $dtosWithPaginationDtoBuilder
    ) {
        $this->dtosWithPaginationDtoBuilder = $dtosWithPaginationDtoBuilder;
    }

    public function get(): DtosWithPaginationDto
    {
        $characters = $this->characterRepository->index($this->sortedAndPaginatedDto);

        $dtos = array_map(fn (?Model $character) => $this->characterQueriesService->getCharacterDtoFromModel(character: $character), $characters->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator($dtos, $characters);
    }
}
