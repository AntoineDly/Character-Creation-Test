<?php

declare(strict_types=1);

namespace App\Games\Controllers;

use App\Games\Queries\GetGameQuery;
use App\Games\Queries\GetGamesQuery;
use App\Games\Repositories\GameRepositoryInterface;
use App\Games\Services\GameQueriesService;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use Exception;
use Illuminate\Http\JsonResponse;

final readonly class GetGameController
{
    public function __construct(
        private GameRepositoryInterface $gameRepository,
        private GameQueriesService $gameQueriesService,
        private ApiControllerInterface $apiController,
    ) {
    }

    public function getGames(): JsonResponse
    {
        try {
            $query = new GetGamesQuery(
                gameRepository: $this->gameRepository,
                gameQueriesService: $this->gameQueriesService,
            );
            $result = $query->get();
        } catch (Exception $e) {
            return $this->apiController->sendException(exception: $e);
        }

        return $this->apiController->sendSuccess(message: 'Games were successfully retrieved', content: [$result]);
    }

    public function getGame(string $gameId): JsonResponse
    {
        try {
            $query = new GetGameQuery(
                gameRepository: $this->gameRepository,
                gameQueriesService: $this->gameQueriesService,
                gameId: $gameId
            );
            $result = $query->get();
        } catch (Exception $e) {
            return $this->apiController->sendException(exception: $e);
        }

        return $this->apiController->sendSuccess(message: 'Game was successfully retrieved', content: [$result]);
    }
}
