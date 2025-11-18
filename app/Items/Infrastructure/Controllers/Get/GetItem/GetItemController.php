<?php

declare(strict_types=1);

namespace App\Items\Infrastructure\Controllers\Get\GetItem;

use App\Items\Application\Queries\GetItemQuery\GetItemQuery;
use App\Shared\Application\Queries\QueryBus;
use App\Shared\Infrastructure\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Infrastructure\Http\Exceptions\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Throwable;

final readonly class GetItemController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private QueryBus $queryBus,
    ) {
    }

    public function __invoke(string $itemId): JsonResponse
    {
        try {
            $query = new GetItemQuery(
                itemId: $itemId
            );
            $result = $this->queryBus->dispatch($query);
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'Item was successfully retrieved.', content: $result);
    }
}
