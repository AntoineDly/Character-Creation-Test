<?php

declare(strict_types=1);

namespace App\Game\Controllers;

use App\Base\Controllers\ApiController\ApiControllerInterface;
use App\Game\Queries\GetGameQuery;
use App\Game\Queries\GetGamesQuery;
use App\Game\Repositories\GameRepositoryInterface;
use App\Game\Services\GameQueriesService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

final class GetGameController extends Controller
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

    public function getGame(string $GameId): JsonResponse
    {
        try {
            $query = new GetGameQuery(
                gameRepository: $this->gameRepository,
                gameQueriesService: $this->gameQueriesService,
                gameId: $GameId
            );
            $result = $query->get();
        } catch (Exception $e) {
            return $this->apiController->sendException(exception: $e);
        }

        return $this->apiController->sendSuccess(message: 'Game was successfully retrieved', content: [$result]);
    }
}
