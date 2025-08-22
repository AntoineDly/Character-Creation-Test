<?php

declare(strict_types=1);

namespace App\Characters\Application\Queries\GetCharactersQuery;

use App\Characters\Domain\Models\Character;
use App\Characters\Domain\Services\CharacterQueriesService;
use App\Characters\Infrastructure\Repositories\CharacterRepositoryInterface;
use App\Shared\Queries\QueryInterface;
use App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationBuilderHelper;
use App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDto;
use App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDtoBuilder;
use App\Shared\SortAndPagination\Dtos\SortedAndPaginatedDto\SortedAndPaginatedDto;

final readonly class GetCharactersQuery implements QueryInterface
{
    /** @use DtosWithPaginationBuilderHelper<Character> */
    use DtosWithPaginationBuilderHelper;

    /** @param DtosWithPaginationDtoBuilder<Character> $dtosWithPaginationDtoBuilder */
    public function __construct(
        private CharacterRepositoryInterface $characterRepository,
        private CharacterQueriesService $characterQueriesService,
        private SortedAndPaginatedDto $sortedAndPaginatedDto,
        DtosWithPaginationDtoBuilder $dtosWithPaginationDtoBuilder
    ) {
        $this->dtosWithPaginationDtoBuilder = $dtosWithPaginationDtoBuilder;
    }

    /** @return DtosWithPaginationDto<Character> */
    public function get(): DtosWithPaginationDto
    {
        $characters = $this->characterRepository->index($this->sortedAndPaginatedDto);

        $dtos = array_map(fn (?Character $character) => $this->characterQueriesService->getCharacterDtoFromModel(character: $character), $characters->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator($dtos, $characters);
    }
}
