<?php

declare(strict_types=1);

namespace App\LinkedItems\Controllers\Api;

use App\LinkedItems\Queries\GetLinkedItemQuery;
use App\LinkedItems\Queries\GetLinkedItemsQuery;
use App\LinkedItems\Repositories\LinkedItemRepositoryInterface;
use App\LinkedItems\Services\LinkedItemQueriesService;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Http\Exceptions\HttpExceptionInterface;
use App\Shared\SortAndPagination\Builders\DtosWithPaginationDtoBuilder;
use App\Shared\SortAndPagination\Dtos\SortedAndPaginatedDto;
use App\Shared\SortAndPagination\Requests\SortedAndPaginatedRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class GetLinkedItemController
{
    public function __construct(
        private LinkedItemRepositoryInterface $linkedItemRepository,
        private LinkedItemQueriesService $linkedItemQueriesService,
        private ApiControllerInterface $apiController,
        private DtosWithPaginationDtoBuilder $dtosWithPaginationDtoBuilder,
    ) {
    }

    public function getLinkedItems(SortedAndPaginatedRequest $request): JsonResponse
    {
        try {
            $sortedAndPaginatedDto = SortedAndPaginatedDto::fromSortedAndPaginatedRequest($request);

            $query = new GetLinkedItemsQuery(
                linkedItemRepository: $this->linkedItemRepository,
                linkedItemQueriesService: $this->linkedItemQueriesService,
                dtosWithPaginationDtoBuilder: $this->dtosWithPaginationDtoBuilder,
                sortedAndPaginatedDto: $sortedAndPaginatedDto,
            );
            $result = $query->get();
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Linked Items were not successfully retrieved.',
                e: $e
            );
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
