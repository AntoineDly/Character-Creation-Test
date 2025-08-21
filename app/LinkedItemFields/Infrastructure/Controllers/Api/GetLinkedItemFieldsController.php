<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Infrastructure\Controllers\Api;

use App\LinkedItemFields\Application\Queries\GetLinkedItemFieldQuery\GetLinkedItemFieldQuery;
use App\LinkedItemFields\Application\Queries\GetLinkedItemFieldsQuery\GetLinkedItemFieldsQuery;
use App\LinkedItemFields\Domain\Models\LinkedItemField;
use App\LinkedItemFields\Domain\Services\LinkedItemFieldQueriesService;
use App\LinkedItemFields\Infrastructure\Repositories\LinkedItemFieldRepositoryInterface;
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
    /** @param DtosWithPaginationDtoBuilder<LinkedItemField> $dtosWithPaginationDtoBuilder */
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
                message: 'LinkedItemFields were not successfully retrieved.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'LinkedItemFields were successfully retrieved.', content: $result);
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
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'Linked ItemField was successfully retrieved.', content: $result);
    }
}
