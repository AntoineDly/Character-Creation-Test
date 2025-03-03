<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Controllers\Api;

use App\LinkedItemFields\Queries\GetLinkedItemFieldQuery;
use App\LinkedItemFields\Queries\GetLinkedItemFieldsQuery;
use App\LinkedItemFields\Repositories\LinkedItemFieldRepositoryInterface;
use App\LinkedItemFields\Services\LinkedItemFieldQueriesService;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Exceptions\Http\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Throwable;

final readonly class GetLinkedItemFieldsController
{
    public function __construct(
        private LinkedItemFieldRepositoryInterface $linkedItemFieldRepository,
        private LinkedItemFieldQueriesService $linkedItemFieldQueriesService,
        private ApiControllerInterface $apiController
    ) {
    }

    public function getLinkedItemFields(): JsonResponse
    {
        try {
            $query = new GetLinkedItemFieldsQuery(
                linkedItemFieldRepository: $this->linkedItemFieldRepository,
                linkedItemFieldQueriesService: $this->linkedItemFieldQueriesService,
            );
            $result = $query->get();
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Linked Item Fields were successfully retrieved.', content: $result);
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
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Linked Item Field was successfully retrieved.', content: $result);
    }
}
