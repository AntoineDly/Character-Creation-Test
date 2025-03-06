<?php

declare(strict_types=1);

namespace App\LinkedItems\Controllers\Api;

use App\LinkedItems\Queries\GetLinkedItemQuery;
use App\LinkedItems\Queries\GetLinkedItemsQuery;
use App\LinkedItems\Repositories\LinkedItemRepositoryInterface;
use App\LinkedItems\Services\LinkedItemQueriesService;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Exceptions\Http\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Throwable;

final readonly class GetLinkedItemController
{
    public function __construct(
        private LinkedItemRepositoryInterface $linkedItemRepository,
        private LinkedItemQueriesService $linkedItemQueriesService,
        private ApiControllerInterface $apiController
    ) {
    }

    public function getLinkedItems(): JsonResponse
    {
        try {
            $query = new GetLinkedItemsQuery(
                linkedItemRepository: $this->linkedItemRepository,
                linkedItemQueriesService: $this->linkedItemQueriesService
            );
            $result = $query->get();
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Linked Items were successfully retrieved.', content: $result);
    }

    public function getLinkedItem(string $linkedItemId): JsonResponse
    {
        try {
            $query = new GetLinkedItemQuery(
                linkedItemRepository: $this->linkedItemRepository,
                linkedItemQueriesService: $this->linkedItemQueriesService,
                linkedItemId: $linkedItemId
            );
            $result = $query->get();
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Linked Item was successfully retrieved.', content: $result);
    }
}
