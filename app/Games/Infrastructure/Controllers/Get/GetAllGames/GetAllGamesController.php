<?php

declare(strict_types=1);

namespace App\Games\Infrastructure\Controllers\Get\GetAllGames;

use App\Games\Application\Queries\GetAllGamesQuery\GetAllGamesQuery;
use App\Helpers\RequestHelper;
use App\Shared\Application\Queries\QueryBus;
use App\Shared\Infrastructure\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Infrastructure\Http\Exceptions\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

final readonly class GetAllGamesController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private QueryBus $queryBus,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $query = new GetAllGamesQuery(
                userId: RequestHelper::getUserId($request)
            );
            $result = $this->queryBus->dispatch($query);
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'All games were successfully retrieved.', content: $result);
    }
}
