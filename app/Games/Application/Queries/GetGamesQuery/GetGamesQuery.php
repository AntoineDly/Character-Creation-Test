<?php

declare(strict_types=1);

namespace App\Games\Application\Queries\GetGamesQuery;

use App\Games\Domain\Dtos\GameDto\GameDtoCollection;
use App\Games\Domain\Models\Game;
use App\Games\Domain\Services\GameQueriesService;
use App\Games\Infrastructure\Repositories\GameRepositoryInterface;
use App\Shared\Dtos\DtoCollectionInterface;
use App\Shared\Queries\QueryInterface;
use App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationBuilderHelper;
use App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDto;
use App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDtoBuilder;
use App\Shared\SortAndPagination\Dtos\SortedAndPaginatedDto\SortedAndPaginatedDto;

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
