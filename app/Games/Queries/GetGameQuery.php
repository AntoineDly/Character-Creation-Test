<?php

declare(strict_types=1);

namespace App\Games\Queries;

use App\Games\Dtos\GameDto;
use App\Games\Repositories\GameRepositoryInterface;
use App\Games\Services\GameQueriesService;
use App\Shared\Queries\QueryInterface;

final readonly class GetGameQuery implements QueryInterface
{
    public function __construct(
        private GameRepositoryInterface $gameRepository,
        private GameQueriesService $gameQueriesService,
        private string $gameId,
    ) {
    }

    public function get(): GameDto
    {
        $game = $this->gameRepository->findById(id: $this->gameId);

        return $this->gameQueriesService->getGameDtoFromModel(game: $game);
    }
}
