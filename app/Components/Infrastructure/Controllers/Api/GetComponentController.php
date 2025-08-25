<?php

declare(strict_types=1);

namespace App\Components\Infrastructure\Controllers\Api;

use App\Components\Application\Queries\GetComponentQuery\GetComponentQuery;
use App\Components\Application\Queries\GetComponentsQuery\GetComponentsQuery;
use App\Components\Domain\Models\Component;
use App\Components\Domain\Services\ComponentQueriesService;
use App\Components\Infrastructure\Repositories\ComponentRepositoryInterface;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDtoBuilder;
use App\Shared\Domain\SortAndPagination\Dtos\SortedAndPaginatedDto\SortedAndPaginatedDto;
use App\Shared\Infrastructure\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Infrastructure\Http\Exceptions\HttpExceptionInterface;
use App\Shared\Infrastructure\Requests\SortedAndPaginatedRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class GetComponentController
{
    /** @param DtosWithPaginationDtoBuilder<Component> $dtosWithPaginationDtoBuilder */
    public function __construct(
        private ComponentRepositoryInterface $componentRepository,
        private ComponentQueriesService $componentQueriesService,
        private ApiControllerInterface $apiController,
        private DtosWithPaginationDtoBuilder $dtosWithPaginationDtoBuilder,
    ) {
    }

    public function getComponents(SortedAndPaginatedRequest $request): JsonResponse
    {
        try {
            $sortedAndPaginatedDto = SortedAndPaginatedDto::fromSortedAndPaginatedRequest($request);

            $query = new GetComponentsQuery(
                componentRepository: $this->componentRepository,
                componentQueriesService: $this->componentQueriesService,
                dtosWithPaginationDtoBuilder: $this->dtosWithPaginationDtoBuilder,
                sortedAndPaginatedDto: $sortedAndPaginatedDto,
            );
            $result = $query->get();
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Components were not successfully retrieved.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'Components were successfully retrieved.', content: $result);
    }

    public function getComponent(string $componentId): JsonResponse
    {
        try {
            $query = new GetComponentQuery(
                componentRepository: $this->componentRepository,
                componentQueriesService: $this->componentQueriesService,
                componentId: $componentId
            );
            $result = $query->get();
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'Component was successfully retrieved.', content: $result);
    }
}
