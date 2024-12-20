<?php

declare(strict_types=1);

namespace App\Fields\Controllers\Api;

use App\Fields\Queries\GetFieldQuery;
use App\Fields\Queries\GetFieldsQuery;
use App\Fields\Repositories\FieldRepositoryInterface;
use App\Fields\Services\FieldQueriesService;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Exceptions\Http\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Throwable;

final readonly class GetFieldsController
{
    public function __construct(
        private FieldRepositoryInterface $fieldRepository,
        private FieldQueriesService $fieldQueriesService,
        private ApiControllerInterface $apiController
    ) {
    }

    public function getFields(): JsonResponse
    {
        try {
            $query = new GetFieldsQuery(
                fieldRepository: $this->fieldRepository,
                fieldQueriesService: $this->fieldQueriesService
            );
            $result = $query->get();
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Fields were successfully retrieved.', content: $result);
    }

    public function getField(string $fieldId): JsonResponse
    {
        try {
            $query = new GetFieldQuery(
                fieldRepository: $this->fieldRepository,
                fieldQueriesService: $this->fieldQueriesService,
                fieldId: $fieldId
            );
            $result = $query->get();
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Field was successfully retrieved.', content: $result);
    }
}
