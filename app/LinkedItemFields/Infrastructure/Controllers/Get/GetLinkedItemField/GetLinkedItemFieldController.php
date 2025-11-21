<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Infrastructure\Controllers\Get\GetLinkedItemField;

use App\LinkedItemFields\Application\Queries\GetLinkedItemFieldQuery\GetLinkedItemFieldQuery;
use App\Shared\Application\Queries\QueryBus;
use App\Shared\Infrastructure\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Infrastructure\Http\Exceptions\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Throwable;

final readonly class GetLinkedItemFieldController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private QueryBus $queryBus,
    ) {
    }

    public function __invoke(string $linkedItemFieldId): JsonResponse
    {
        try {
            $query = new GetLinkedItemFieldQuery(
                linkedItemFieldId: $linkedItemFieldId
            );
            $result = $this->queryBus->dispatch($query);
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'LinkedItem Field was successfully retrieved.', content: $result);
    }
}
