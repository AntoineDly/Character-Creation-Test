<?php

declare(strict_types=1);

namespace App\Games\Infrastructure\Controllers\Get\GetGame;

use App\Games\Application\Queries\GetGameQuery\GetGameQuery;
use App\Shared\Application\Queries\QueryBus;
use App\Shared\Infrastructure\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Infrastructure\Http\Exceptions\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Throwable;

final readonly class GetGameController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private QueryBus $queryBus,
    ) {
    }

    public function __invoke(string $gameId): JsonResponse
    {
        try {
            $query = new GetGameQuery(
                gameId: $gameId
            );
            $result = $this->queryBus->dispatch($query);
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'Game was successfully retrieved.', content: $result);
    }
}
