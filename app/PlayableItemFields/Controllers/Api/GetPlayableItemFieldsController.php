<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Controllers\Api;

use App\PlayableItemFields\Models\PlayableItemField;
use App\PlayableItemFields\Queries\GetPlayableItemFieldQuery;
use App\PlayableItemFields\Queries\GetPlayableItemFieldsQuery;
use App\PlayableItemFields\Repositories\PlayableItemFieldRepositoryInterface;
use App\PlayableItemFields\Services\PlayableItemFieldQueriesService;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Http\Exceptions\HttpExceptionInterface;
use App\Shared\SortAndPagination\Builders\DtosWithPaginationDtoBuilder;
use App\Shared\SortAndPagination\Dtos\SortedAndPaginatedDto;
use App\Shared\SortAndPagination\Requests\SortedAndPaginatedRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class GetPlayableItemFieldsController
{
    /** @param DtosWithPaginationDtoBuilder<PlayableItemField> $dtosWithPaginationDtoBuilder */
    public function __construct(
        private PlayableItemFieldRepositoryInterface $playableItemFieldRepository,
        private PlayableItemFieldQueriesService $playableItemFieldQueriesService,
        private ApiControllerInterface $apiController,
        private DtosWithPaginationDtoBuilder $dtosWithPaginationDtoBuilder,
    ) {
    }

    public function getPlayableItemFields(SortedAndPaginatedRequest $request): JsonResponse
    {
        try {
            $sortedAndPaginatedDto = SortedAndPaginatedDto::fromSortedAndPaginatedRequest($request);

            $query = new GetPlayableItemFieldsQuery(
                playableItemFieldRepository: $this->playableItemFieldRepository,
                playableItemFieldQueriesService: $this->playableItemFieldQueriesService,
                dtosWithPaginationDtoBuilder: $this->dtosWithPaginationDtoBuilder,
                sortedAndPaginatedDto: $sortedAndPaginatedDto,
            );
            $result = $query->get();
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Playable ItemsFields were not successfully retrieved.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'Playable ItemFields were successfully retrieved.', content: $result);
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
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'Playable ItemField was successfully retrieved.', content: $result);
    }
}
