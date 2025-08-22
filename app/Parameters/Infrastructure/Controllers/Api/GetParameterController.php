<?php

declare(strict_types=1);

namespace App\Parameters\Infrastructure\Controllers\Api;

use App\Parameters\Application\Queries\GetParameterQuery\GetParameterQuery;
use App\Parameters\Application\Queries\GetParametersQuery\GetParametersQuery;
use App\Parameters\Domain\Models\Parameter;
use App\Parameters\Domain\Services\ParameterQueriesService;
use App\Parameters\Infrastructure\Repositories\ParameterRepositoryInterface;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Http\Exceptions\HttpExceptionInterface;
use App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDtoBuilder;
use App\Shared\SortAndPagination\Dtos\SortedAndPaginatedDto\SortedAndPaginatedDto;
use App\Shared\SortAndPagination\Dtos\SortedAndPaginatedDto\SortedAndPaginatedRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class GetParameterController
{
    /** @param DtosWithPaginationDtoBuilder<Parameter> $dtosWithPaginationDtoBuilder */
    public function __construct(
        private ParameterRepositoryInterface $parameterRepository,
        private ParameterQueriesService $parameterQueriesService,
        private ApiControllerInterface $apiController,
        private DtosWithPaginationDtoBuilder $dtosWithPaginationDtoBuilder,
    ) {
    }

    public function getParameters(SortedAndPaginatedRequest $request): JsonResponse
    {
        try {
            $sortedAndPaginatedDto = SortedAndPaginatedDto::fromSortedAndPaginatedRequest($request);

            $query = new GetParametersQuery(
                parameterRepository: $this->parameterRepository,
                parameterQueriesService: $this->parameterQueriesService,
                sortedAndPaginatedDto: $sortedAndPaginatedDto,
                dtosWithPaginationDtoBuilder: $this->dtosWithPaginationDtoBuilder,
            );
            $result = $query->get();
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Parameters were not successfully retrieved.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'Parameters were successfully retrieved.', content: $result);
    }

    public function getParameter(string $parameterId): JsonResponse
    {
        try {
            $query = new GetParameterQuery(
                parameterRepository: $this->parameterRepository,
                parameterQueriesService: $this->parameterQueriesService,
                parameterId: $parameterId,
            );
            $result = $query->get();
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'Parameter was successfully retrieved.', content: $result);
    }
}
