<?php

declare(strict_types=1);

namespace App\ItemFields\Controllers\Api;

use App\ItemFields\Models\ItemField;
use App\ItemFields\Queries\GetItemFieldQuery;
use App\ItemFields\Queries\GetItemFieldsQuery;
use App\ItemFields\Repositories\ItemFieldRepositoryInterface;
use App\ItemFields\Services\ItemFieldQueriesService;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Http\Exceptions\HttpExceptionInterface;
use App\Shared\SortAndPagination\Builders\DtosWithPaginationDtoBuilder;
use App\Shared\SortAndPagination\Dtos\SortedAndPaginatedDto;
use App\Shared\SortAndPagination\Requests\SortedAndPaginatedRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class GetItemFieldsController
{
    /** @param DtosWithPaginationDtoBuilder<ItemField> $dtosWithPaginationDtoBuilder */
    public function __construct(
        private ItemFieldRepositoryInterface $itemFieldRepository,
        private ItemFieldQueriesService $itemFieldQueriesService,
        private ApiControllerInterface $apiController,
        private DtosWithPaginationDtoBuilder $dtosWithPaginationDtoBuilder,
    ) {
    }

    public function getItemFields(SortedAndPaginatedRequest $request): JsonResponse
    {
        try {
            $sortedAndPaginatedDto = SortedAndPaginatedDto::fromSortedAndPaginatedRequest($request);

            $query = new GetItemFieldsQuery(
                itemFieldRepository: $this->itemFieldRepository,
                itemFieldQueriesService: $this->itemFieldQueriesService,
                dtosWithPaginationDtoBuilder: $this->dtosWithPaginationDtoBuilder,
                sortedAndPaginatedDto: $sortedAndPaginatedDto,
            );
            $result = $query->get();
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'ItemFields were not successfully retrieved.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'ItemFields were successfully retrieved.', content: $result);
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
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'ItemField was successfully retrieved.', content: $result);
    }
}
