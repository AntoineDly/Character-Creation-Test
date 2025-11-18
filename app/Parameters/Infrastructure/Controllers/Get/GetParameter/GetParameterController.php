<?php

declare(strict_types=1);

namespace App\Parameters\Infrastructure\Controllers\Get\GetParameter;

use App\Parameters\Application\Queries\GetParameterQuery\GetParameterQuery;
use App\Shared\Application\Queries\QueryBus;
use App\Shared\Infrastructure\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Infrastructure\Http\Exceptions\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Throwable;

final readonly class GetParameterController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private QueryBus $queryBus,
    ) {
    }

    public function __invoke(string $parameterId): JsonResponse
    {
        try {
            $query = new GetParameterQuery(
                parameterId: $parameterId,
            );
            $result = $this->queryBus->dispatch($query);
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'Parameter was successfully retrieved.', content: $result);
    }
}
