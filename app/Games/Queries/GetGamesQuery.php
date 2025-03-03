<?php

declare(strict_types=1);

namespace App\Games\Queries;

use App\Games\Dtos\GameDto;
use App\Games\Repositories\GameRepositoryInterface;
use App\Games\Services\GameQueriesService;
use App\Shared\Queries\QueryInterface;
use Illuminate\Database\Eloquent\Model;

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

        return array_map(fn (?Model $game) => $this->gameQueriesService->getGameDtoFromModel(game: $game), $games->all());
    }
}
