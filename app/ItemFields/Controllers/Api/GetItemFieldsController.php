<?php

declare(strict_types=1);

namespace App\ItemFields\Controllers\Api;

use App\ItemFields\Queries\GetItemFieldQuery;
use App\ItemFields\Queries\GetItemFieldsQuery;
use App\ItemFields\Repositories\ItemFieldRepositoryInterface;
use App\ItemFields\Services\ItemFieldQueriesService;
use App\Shared\Builders\DtosWithPaginationDtoBuilder;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Dtos\SortedAndPaginatedDto;
use App\Shared\Exceptions\Http\HttpExceptionInterface;
use App\Shared\Requests\SortedAndPaginatedRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class GetItemFieldsController
{
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
                message: 'Item Fields were not successfully retrieved.',
                e: $e
            );
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
