<?php

declare(strict_types=1);

namespace App\LinkedItems\Infrastructure\Controllers\Get\GetLinkedItem;

use App\LinkedItems\Application\Queries\GetLinkedItemQuery\GetLinkedItemQuery;
use App\Shared\Application\Queries\QueryBus;
use App\Shared\Infrastructure\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Infrastructure\Http\Exceptions\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Throwable;

final readonly class GetLinkedItemController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private QueryBus $queryBus,
    ) {
    }

    public function __invoke(string $linkedItemId): JsonResponse
    {
        try {
            $query = new GetLinkedItemQuery(
                linkedItemId: $linkedItemId
            );
            $result = $this->queryBus->dispatch($query);
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'LinkedItem was successfully retrieved.', content: $result);
    }
}
