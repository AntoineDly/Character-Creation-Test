<?php

declare(strict_types=1);

namespace App\ComponentFields\Controllers\Api;

use App\ComponentFields\Queries\GetComponentFieldQuery;
use App\ComponentFields\Queries\GetComponentFieldsQuery;
use App\ComponentFields\Repositories\ComponentFieldRepositoryInterface;
use App\ComponentFields\Services\ComponentFieldQueriesService;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Http\Exceptions\HttpExceptionInterface;
use App\Shared\SortAndPagination\Builders\DtosWithPaginationDtoBuilder;
use App\Shared\SortAndPagination\Dtos\SortedAndPaginatedDto;
use App\Shared\SortAndPagination\Requests\SortedAndPaginatedRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class GetComponentFieldsController
{
    public function __construct(
        private ComponentFieldRepositoryInterface $componentFieldRepository,
        private ComponentFieldQueriesService $componentFieldQueriesService,
        private ApiControllerInterface $apiController,
        private DtosWithPaginationDtoBuilder $dtosWithPaginationDtoBuilder,
    ) {
    }

    public function getComponentFields(SortedAndPaginatedRequest $request): JsonResponse
    {
        try {
            $sortedAndPaginatedDto = SortedAndPaginatedDto::fromSortedAndPaginatedRequest($request);

            $query = new GetComponentFieldsQuery(
                componentFieldRepository: $this->componentFieldRepository,
                componentFieldQueriesService: $this->componentFieldQueriesService,
                dtosWithPaginationDtoBuilder: $this->dtosWithPaginationDtoBuilder,
                sortedAndPaginatedDto: $sortedAndPaginatedDto,
            );
            $result = $query->get();
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Component Fields were not successfully retrieved.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'Component Fields were successfully retrieved.', content: $result);
    }

    public function getComponentField(string $componentFieldId): JsonResponse
    {
        try {
            $query = new GetComponentFieldQuery(
                componentFieldRepository: $this->componentFieldRepository,
                componentFieldQueriesService: $this->componentFieldQueriesService,
                componentFieldId: $componentFieldId
            );
            $result = $query->get();
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'Component Field was successfully retrieved.', content: $result);
    }
}
