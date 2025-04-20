<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Controllers\Api;

use App\LinkedItemFields\Queries\GetLinkedItemFieldQuery;
use App\LinkedItemFields\Queries\GetLinkedItemFieldsQuery;
use App\LinkedItemFields\Repositories\LinkedItemFieldRepositoryInterface;
use App\LinkedItemFields\Services\LinkedItemFieldQueriesService;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Http\Exceptions\HttpExceptionInterface;
use App\Shared\SortAndPagination\Builders\DtosWithPaginationDtoBuilder;
use App\Shared\SortAndPagination\Dtos\SortedAndPaginatedDto;
use App\Shared\SortAndPagination\Requests\SortedAndPaginatedRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class GetLinkedItemFieldsController
{
    public function __construct(
        private LinkedItemFieldRepositoryInterface $linkedItemFieldRepository,
        private LinkedItemFieldQueriesService $linkedItemFieldQueriesService,
        private ApiControllerInterface $apiController,
        private DtosWithPaginationDtoBuilder $dtosWithPaginationDtoBuilder,
    ) {
    }

    public function getLinkedItemFields(SortedAndPaginatedRequest $request): JsonResponse
    {
        try {
            $sortedAndPaginatedDto = SortedAndPaginatedDto::fromSortedAndPaginatedRequest($request);

            $query = new GetLinkedItemFieldsQuery(
                linkedItemFieldRepository: $this->linkedItemFieldRepository,
                linkedItemFieldQueriesService: $this->linkedItemFieldQueriesService,
                dtosWithPaginationDtoBuilder: $this->dtosWithPaginationDtoBuilder,
                sortedAndPaginatedDto: $sortedAndPaginatedDto,
            );
            $result = $query->get();
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Linked Item Fields were not successfully retrieved.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Linked Item Fields were successfully retrieved.', content: $result);
    }

    public function getLinkedItemField(string $linkedItemFieldId): JsonResponse
    {
        try {
            $query = new GetLinkedItemFieldQuery(
                linkedItemFieldRepository: $this->linkedItemFieldRepository,
                linkedItemFieldQueriesService: $this->linkedItemFieldQueriesService,
                linkedItemFieldId: $linkedItemFieldId
            );
            $result = $query->get();
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Linked Item Field was successfully retrieved.', content: $result);
    }
}
