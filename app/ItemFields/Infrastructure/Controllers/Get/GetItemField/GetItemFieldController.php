<?php

declare(strict_types=1);

namespace App\ItemFields\Infrastructure\Controllers\Get\GetItemField;

use App\ItemFields\Application\Queries\GetItemFieldQuery\GetItemFieldQuery;
use App\Shared\Application\Queries\QueryBus;
use App\Shared\Infrastructure\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Infrastructure\Http\Exceptions\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Throwable;

final readonly class GetItemFieldController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private QueryBus $queryBus,
    ) {
    }

    public function __invoke(string $itemFieldId): JsonResponse
    {
        try {
            $query = new GetItemFieldQuery(
                itemFieldId: $itemFieldId
            );
            $result = $this->queryBus->dispatch($query);
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'ItemField was successfully retrieved.', content: $result);
    }
}
