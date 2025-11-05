<?php

declare(strict_types=1);

namespace App\Components\Infrastructure\Controllers\Get\GetComponent;

use App\Components\Application\Queries\GetComponentQuery\GetComponentQuery;
use App\Shared\Application\Queries\QueryBus;
use App\Shared\Infrastructure\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Infrastructure\Http\Exceptions\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Throwable;

final readonly class GetComponentController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private QueryBus $queryBus,
    ) {
    }

    public function __invoke(string $componentId): JsonResponse
    {
        try {
            $query = new GetComponentQuery(
                componentId: $componentId
            );
            $result = $this->queryBus->dispatch($query);
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'Component was successfully retrieved.', content: $result);
    }
}
