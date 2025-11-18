<?php

declare(strict_types=1);

namespace App\Games\Infrastructure\Controllers\Get\GetGameWithCategoriesAndPlayableItems;

use App\Games\Application\Queries\GetGameWithCategoriesAndPlayableItemsQuery\GetGameWithCategoriesAndPlayableItemsQuery;
use App\Shared\Application\Queries\QueryBus;
use App\Shared\Infrastructure\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Infrastructure\Http\Exceptions\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Throwable;

final readonly class GetGameWithCategoriesAndPlayableItemsController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private QueryBus $queryBus,
    ) {
    }

    public function __invoke(string $gameId): JsonResponse
    {
        try {
            $query = new GetGameWithCategoriesAndPlayableItemsQuery(
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
