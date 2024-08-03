<?php

declare(strict_types=1);

namespace App\Game\Queries;

use App\Game\Dtos\GameDto;
use App\Game\Repositories\GameRepositoryInterface;
use App\Game\Services\GameQueriesService;
use App\Shared\Queries\QueryInterface;

final readonly class GetGamesQuery implements QueryInterface
{
    public function __construct(
        private GameRepositoryInterface $gameRepository,
        private GameQueriesService $gameQueriesService,
    ) {
    }

    /** @return GameDto[] */
    public function get(): array
    {
        $games = $this->gameRepository->index();

        /** @var GameDto[] $gamesDtos */
        $gamesDtos = [];

        foreach ($games as $game) {
            $gamesDtos[] = $this->gameQueriesService->getGameDtoFromModel(game: $game);
        }

        return $gamesDtos;
    }
}
