<?php

declare(strict_types=1);

namespace App\Items\Controllers;

use App\Base\Controllers\ApiController\ApiControllerInterface;
use App\Items\Queries\GetItemQuery;
use App\Items\Queries\GetItemsQuery;
use App\Items\Repositories\ItemRepositoryInterface;
use App\Items\Services\ItemQueriesService;
use Exception;
use Illuminate\Http\JsonResponse;

final readonly class GetItemController
{
    public function __construct(
        private ItemRepositoryInterface $itemRepository,
        private ItemQueriesService $itemQueriesService,
        private ApiControllerInterface $apiController
    ) {
    }

    public function getItems(): JsonResponse
    {
        try {
            $query = new GetItemsQuery(
                itemRepository: $this->itemRepository,
                itemQueriesService: $this->itemQueriesService
            );
            $result = $query->get();
        } catch (Exception $e) {
            return $this->apiController->sendException(exception: $e);
        }

        return $this->apiController->sendSuccess(message: 'Items were successfully retrieved', content: [$result]);
    }

    public function getItem(string $itemId): JsonResponse
    {
        try {
            $query = new GetItemQuery(
                itemRepository: $this->itemRepository,
                itemQueriesService: $this->itemQueriesService,
                itemId: $itemId
            );
            $result = $query->get();
        } catch (Exception $e) {
            return $this->apiController->sendException(exception: $e);
        }

        return $this->apiController->sendSuccess(message: 'Item was successfully retrieved', content: [$result]);
    }
}
