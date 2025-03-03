<?php

declare(strict_types=1);

namespace App\ItemFields\Controllers\Api;

use App\ItemFields\Queries\GetItemFieldQuery;
use App\ItemFields\Queries\GetItemFieldsQuery;
use App\ItemFields\Repositories\ItemFieldRepositoryInterface;
use App\ItemFields\Services\ItemFieldQueriesService;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Exceptions\Http\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Throwable;

final readonly class GetItemFieldsController
{
    public function __construct(
        private ItemFieldRepositoryInterface $itemFieldRepository,
        private ItemFieldQueriesService $itemFieldQueriesService,
        private ApiControllerInterface $apiController
    ) {
    }

    public function getItemFields(): JsonResponse
    {
        try {
            $query = new GetItemFieldsQuery(
                itemFieldRepository: $this->itemFieldRepository,
                itemFieldQueriesService: $this->itemFieldQueriesService
            );
            $result = $query->get();
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Item Fields were successfully retrieved.', content: $result);
    }

    public function getItemField(string $itemFieldId): JsonResponse
    {
        try {
            $query = new GetItemFieldQuery(
                itemFieldRepository: $this->itemFieldRepository,
                itemFieldQueriesService: $this->itemFieldQueriesService,
                itemFieldId: $itemFieldId
            );
            $result = $query->get();
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Item Field was successfully retrieved.', content: $result);
    }
}
