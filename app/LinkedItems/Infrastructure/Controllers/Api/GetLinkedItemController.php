<?php

declare(strict_types=1);

namespace App\LinkedItems\Infrastructure\Controllers\Api;

use App\LinkedItems\Application\Queries\GetLinkedItemQuery\GetLinkedItemQuery;
use App\LinkedItems\Application\Queries\GetLinkedItemsQuery\GetLinkedItemsQuery;
use App\LinkedItems\Domain\Models\LinkedItem;
use App\LinkedItems\Domain\Services\LinkedItemQueriesService;
use App\LinkedItems\Infrastructure\Repositories\LinkedItemRepositoryInterface;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Http\Exceptions\HttpExceptionInterface;
use App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDtoBuilder;
use App\Shared\SortAndPagination\Dtos\SortedAndPaginatedDto\SortedAndPaginatedDto;
use App\Shared\SortAndPagination\Dtos\SortedAndPaginatedDto\SortedAndPaginatedRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class GetLinkedItemController
{
    /** @param DtosWithPaginationDtoBuilder<LinkedItem> $dtosWithPaginationDtoBuilder */
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
            return $this->apiController->sendUncaughtThrowable($e);
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
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'LinkedItem was successfully retrieved.', content: $result);
    }
}
