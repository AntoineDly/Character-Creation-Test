<?php

declare(strict_types=1);

namespace App\Games\Queries;

use App\Games\Collection\GameDtoCollection;
use App\Games\Models\Game;
use App\Games\Repositories\GameRepositoryInterface;
use App\Games\Services\GameQueriesService;
use App\Shared\Collection\DtoCollectionInterface;
use App\Shared\Queries\QueryInterface;
use App\Shared\SortAndPagination\Builders\DtosWithPaginationDtoBuilder;
use App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto;
use App\Shared\SortAndPagination\Dtos\SortedAndPaginatedDto;
use App\Shared\SortAndPagination\Traits\DtosWithPaginationBuilderHelper;

final readonly class GetGamesQuery implements QueryInterface
{
    /** @use DtosWithPaginationBuilderHelper<Game> */
    use DtosWithPaginationBuilderHelper;

    /** @param DtosWithPaginationDtoBuilder<Game> $dtosWithPaginationDtoBuilder */
    public function __construct(
        private GameRepositoryInterface $gameRepository,
        private GameQueriesService $gameQueriesService,
        private SortedAndPaginatedDto $sortedAndPaginatedDto,
        DtosWithPaginationDtoBuilder $dtosWithPaginationDtoBuilder,
    ) {
        $this->dtosWithPaginationDtoBuilder = $dtosWithPaginationDtoBuilder;
    }

    /** @return DtosWithPaginationDto<Game> */
    public function get(): DtosWithPaginationDto
    {
        $games = $this->gameRepository->index($this->sortedAndPaginatedDto);

        /** @var DtoCollectionInterface<Game> $dtos */
        $dtos = GameDtoCollection::fromMap(fn (Game $game) => $this->gameQueriesService->getGameDtoFromModel(game: $game), $games->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator($dtos, $games);
    }
}
