<?php

declare(strict_types=1);

namespace App\PlayableItems\Controllers\Api;

use App\PlayableItems\Queries\GetPlayableItemQuery;
use App\PlayableItems\Queries\GetPlayableItemsQuery;
use App\PlayableItems\Repositories\PlayableItemRepositoryInterface;
use App\PlayableItems\Services\PlayableItemQueriesService;
use App\Shared\Builders\DtosWithPaginationDtoBuilder;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Dtos\SortedAndPaginatedDto;
use App\Shared\Exceptions\Http\HttpExceptionInterface;
use App\Shared\Requests\SortedAndPaginatedRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class GetPlayableItemController
{
    public function __construct(
        private PlayableItemRepositoryInterface $playableItemRepository,
        private PlayableItemQueriesService $playableItemQueriesService,
        private ApiControllerInterface $apiController,
        private DtosWithPaginationDtoBuilder $dtosWithPaginationDtoBuilder,
    ) {
    }

    public function getPlayableItems(SortedAndPaginatedRequest $request): JsonResponse
    {
        try {
            /** @var array{'sortOrder': string, 'perPage': int, 'page': int} $validatedData */
            $validatedData = $request->validated();
            $sortedAndPaginatedDto = SortedAndPaginatedDto::fromArray($validatedData);

            $query = new GetPlayableItemsQuery(
                playableItemRepository: $this->playableItemRepository,
                playableItemQueriesService: $this->playableItemQueriesService,
                dtosWithPaginationDtoBuilder: $this->dtosWithPaginationDtoBuilder,
                sortedAndPaginatedDto: $sortedAndPaginatedDto,
            );
            $result = $query->get();
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Playable Items were not successfully retrieved.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Playable Items were successfully retrieved.', content: $result);
    }

    public function getPlayableItem(string $playableItemId): JsonResponse
    {
        try {
            $query = new GetPlayableItemQuery(
                playableItemRepository: $this->playableItemRepository,
                playableItemQueriesService: $this->playableItemQueriesService,
                playableItemId: $playableItemId
            );
            $result = $query->get();
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Playable Item was successfully retrieved.', content: $result);
    }
}
