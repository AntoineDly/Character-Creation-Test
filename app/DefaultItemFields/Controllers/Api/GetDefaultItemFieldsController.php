<?php

declare(strict_types=1);

namespace App\DefaultItemFields\Controllers\Api;

use App\DefaultItemFields\Queries\GetDefaultItemFieldQuery;
use App\DefaultItemFields\Queries\GetDefaultItemFieldsQuery;
use App\DefaultItemFields\Repositories\DefaultItemFieldRepositoryInterface;
use App\DefaultItemFields\Services\DefaultItemFieldQueriesService;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Exceptions\Http\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Throwable;

final readonly class GetDefaultItemFieldsController
{
    public function __construct(
        private DefaultItemFieldRepositoryInterface $defaultItemFieldRepository,
        private DefaultItemFieldQueriesService $defaultItemFieldQueriesService,
        private ApiControllerInterface $apiController
    ) {
    }

    public function getDefaultItemFields(): JsonResponse
    {
        try {
            $query = new GetDefaultItemFieldsQuery(
                defaultItemFieldRepository: $this->defaultItemFieldRepository,
                defaultItemFieldQueriesService: $this->defaultItemFieldQueriesService
            );
            $result = $query->get();
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Default Item Fields were successfully retrieved.', content: $result);
    }

    public function getDefaultItemField(string $defaultItemFieldId): JsonResponse
    {
        try {
            $query = new GetDefaultItemFieldQuery(
                defaultItemFieldRepository: $this->defaultItemFieldRepository,
                defaultItemFieldQueriesService: $this->defaultItemFieldQueriesService,
                defaultItemFieldId: $defaultItemFieldId
            );
            $result = $query->get();
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Default Item Field was successfully retrieved.', content: $result);
    }
}
