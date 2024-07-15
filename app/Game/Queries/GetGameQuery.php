<?php

declare(strict_types=1);

namespace App\Game\Queries;

use App\Base\Queries\QueryInterface;
use App\Game\Dtos\GameDto;
use App\Game\Repositories\GameRepositoryInterface;
use App\Game\Services\GameQueriesService;

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
        $game = $this->gameRepository->findById($this->gameId);

        return $this->gameQueriesService->getGameDtoFromModel(game: $game);
    }
}
