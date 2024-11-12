<?php

declare(strict_types=1);

namespace App\Components\Controllers\Api;

use App\Components\Queries\GetComponentQuery;
use App\Components\Queries\GetComponentsQuery;
use App\Components\Repositories\ComponentRepositoryInterface;
use App\Components\Services\ComponentQueriesService;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Exceptions\Http\HttpExceptionInterface;
use Exception;
use Illuminate\Http\JsonResponse;

final readonly class GetComponentController
{
    public function __construct(
        private ComponentRepositoryInterface $componentRepository,
        private ComponentQueriesService $componentQueriesService,
        private ApiControllerInterface $apiController
    ) {
    }

    public function getComponents(): JsonResponse
    {
        try {
            $query = new GetComponentsQuery(
                componentRepository: $this->componentRepository,
                componentQueriesService: $this->componentQueriesService
            );
            $result = $query->get();
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Exception $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Components were successfully retrieved.', content: [$result]);
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
        } catch (Exception $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Component was successfully retrieved.', content: [$result]);
    }
}
