<?php

declare(strict_types=1);

namespace App\ComponentFields\Controllers\Api;

use App\ComponentFields\Queries\GetComponentFieldQuery;
use App\ComponentFields\Queries\GetComponentFieldsQuery;
use App\ComponentFields\Repositories\ComponentFieldRepositoryInterface;
use App\ComponentFields\Services\ComponentFieldQueriesService;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Exceptions\Http\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Throwable;

final readonly class GetComponentFieldsController
{
    public function __construct(
        private ComponentFieldRepositoryInterface $componentFieldRepository,
        private ComponentFieldQueriesService $componentFieldQueriesService,
        private ApiControllerInterface $apiController
    ) {
    }

    public function getComponentFields(): JsonResponse
    {
        try {
            $query = new GetComponentFieldsQuery(
                componentFieldRepository: $this->componentFieldRepository,
                componentFieldQueriesService: $this->componentFieldQueriesService
            );
            $result = $query->get();
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendExceptionNotCatch($e);
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
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Component Field was successfully retrieved.', content: $result);
    }
}
