<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Infrastructure\Controllers\Api;

use App\LinkedItemFields\Application\Queries\GetLinkedItemFieldQuery\GetLinkedItemFieldQuery;
use App\LinkedItemFields\Application\Queries\GetLinkedItemFieldsQuery\GetLinkedItemFieldsQuery;
use App\Shared\Application\Queries\QueryBus;
use App\Shared\Domain\SortAndPagination\Dtos\SortedAndPaginatedDto\SortedAndPaginatedDto;
use App\Shared\Infrastructure\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Infrastructure\Http\Exceptions\HttpExceptionInterface;
use App\Shared\Infrastructure\Requests\SortedAndPaginatedRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class GetLinkedItemFieldsController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private QueryBus $queryBus,
    ) {
    }

    public function getLinkedItemFields(SortedAndPaginatedRequest $request): JsonResponse
    {
        try {
            $sortedAndPaginatedDto = SortedAndPaginatedDto::fromSortedAndPaginatedRequest($request);

            $query = new GetLinkedItemFieldsQuery(
                sortedAndPaginatedDto: $sortedAndPaginatedDto,
            );
            $result = $this->queryBus->dispatch($query);
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
                linkedItemFieldId: $linkedItemFieldId
            );
            $result = $this->queryBus->dispatch($query);
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'Linked ItemField was successfully retrieved.', content: $result);
    }
}
