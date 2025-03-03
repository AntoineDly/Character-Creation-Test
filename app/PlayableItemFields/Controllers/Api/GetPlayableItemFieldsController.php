<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Controllers\Api;

use App\PlayableItemFields\Queries\GetPlayableItemFieldQuery;
use App\PlayableItemFields\Queries\GetPlayableItemFieldsQuery;
use App\PlayableItemFields\Repositories\PlayableItemFieldRepositoryInterface;
use App\PlayableItemFields\Services\PlayableItemFieldQueriesService;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Exceptions\Http\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Throwable;

final readonly class GetPlayableItemFieldsController
{
    public function __construct(
        private PlayableItemFieldRepositoryInterface $playableItemFieldRepository,
        private PlayableItemFieldQueriesService $playableItemFieldQueriesService,
        private ApiControllerInterface $apiController
    ) {
    }

    public function getPlayableItemFields(): JsonResponse
    {
        try {
            $query = new GetPlayableItemFieldsQuery(
                playableItemFieldRepository: $this->playableItemFieldRepository,
                playableItemFieldQueriesService: $this->playableItemFieldQueriesService
            );
            $result = $query->get();
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Playable Item Fields were successfully retrieved.', content: $result);
    }

    public function getPlayableItemField(string $playableItemFieldId): JsonResponse
    {
        try {
            $query = new GetPlayableItemFieldQuery(
                playableItemFieldRepository: $this->playableItemFieldRepository,
                playableItemFieldQueriesService: $this->playableItemFieldQueriesService,
                playableItemFieldId: $playableItemFieldId
            );
            $result = $query->get();
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Playable Item Field was successfully retrieved.', content: $result);
    }
}
