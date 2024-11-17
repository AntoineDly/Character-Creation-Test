<?php

declare(strict_types=1);

namespace App\DefaultComponentFields\Controllers\Api;

use App\DefaultComponentFields\Queries\GetDefaultComponentFieldQuery;
use App\DefaultComponentFields\Queries\GetDefaultComponentFieldsQuery;
use App\DefaultComponentFields\Repositories\DefaultComponentFieldRepositoryInterface;
use App\DefaultComponentFields\Services\DefaultComponentFieldQueriesService;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Exceptions\Http\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Throwable;

final readonly class GetDefaultComponentFieldsController
{
    public function __construct(
        private DefaultComponentFieldRepositoryInterface $defaultComponentFieldRepository,
        private DefaultComponentFieldQueriesService $defaultComponentFieldQueriesService,
        private ApiControllerInterface $apiController
    ) {
    }

    public function getDefaultComponentFields(): JsonResponse
    {
        try {
            $query = new GetDefaultComponentFieldsQuery(
                defaultComponentFieldRepository: $this->defaultComponentFieldRepository,
                defaultComponentFieldQueriesService: $this->defaultComponentFieldQueriesService
            );
            $result = $query->get();
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Default Component Fields were successfully retrieved.', content: $result);
    }

    public function getDefaultComponentField(string $defaultComponentFieldId): JsonResponse
    {
        try {
            $query = new GetDefaultComponentFieldQuery(
                defaultComponentFieldRepository: $this->defaultComponentFieldRepository,
                defaultComponentFieldQueriesService: $this->defaultComponentFieldQueriesService,
                defaultComponentFieldId: $defaultComponentFieldId
            );
            $result = $query->get();
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Default Component Field was successfully retrieved.', content: $result);
    }
}
