<?php

declare(strict_types=1);

namespace App\ComponentFields\Infrastructure\Controllers\Get\GetComponentField;

use App\ComponentFields\Application\Queries\GetComponentFieldQuery\GetComponentFieldQuery;
use App\Shared\Application\Queries\QueryBus;
use App\Shared\Infrastructure\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Infrastructure\Http\Exceptions\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Throwable;

final readonly class GetComponentFieldController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private QueryBus $queryBus,
    ) {
    }

    public function __invoke(string $componentFieldId): JsonResponse
    {
        try {
            $query = new GetComponentFieldQuery(
                componentFieldId: $componentFieldId
            );
            $result = $this->queryBus->dispatch($query);
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'ComponentField was successfully retrieved.', content: $result);
    }
}
