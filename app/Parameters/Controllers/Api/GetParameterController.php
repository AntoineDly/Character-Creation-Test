<?php

declare(strict_types=1);

namespace App\Parameters\Controllers\Api;

use App\Parameters\Queries\GetParameterQuery;
use App\Parameters\Queries\GetParametersQuery;
use App\Parameters\Repositories\ParameterRepositoryInterface;
use App\Parameters\Services\ParameterQueriesService;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Exceptions\Http\HttpExceptionInterface;
use Exception;
use Illuminate\Http\JsonResponse;

final readonly class GetParameterController
{
    public function __construct(
        private ParameterRepositoryInterface $parameterRepository,
        private ParameterQueriesService $parameterQueriesService,
        private ApiControllerInterface $apiController,
    ) {
    }

    public function getParameters(): JsonResponse
    {
        try {
            $query = new GetParametersQuery(
                parameterRepository: $this->parameterRepository,
                parameterQueriesService: $this->parameterQueriesService,
            );
            $result = $query->get();
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException(exception: $e);
        } catch (Exception $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Parameters were successfully retrieved.', content: [$result]);
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
            return $this->apiController->sendException(exception: $e);
        } catch (Exception $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Parameter was successfully retrieved.', content: [$result]);
    }
}