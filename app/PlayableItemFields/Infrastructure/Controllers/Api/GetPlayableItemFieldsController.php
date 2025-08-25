<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Infrastructure\Controllers\Api;

use App\PlayableItemFields\Application\Queries\GetPlayableItemFieldQuery\GetPlayableItemFieldQuery;
use App\PlayableItemFields\Application\Queries\GetPlayableItemFieldsQuery\GetPlayableItemFieldsQuery;
use App\PlayableItemFields\Domain\Models\PlayableItemField;
use App\PlayableItemFields\Domain\Services\PlayableItemFieldQueriesService;
use App\PlayableItemFields\Infrastructure\Repositories\PlayableItemFieldRepositoryInterface;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDtoBuilder;
use App\Shared\Domain\SortAndPagination\Dtos\SortedAndPaginatedDto\SortedAndPaginatedDto;
use App\Shared\Infrastructure\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Infrastructure\Http\Exceptions\HttpExceptionInterface;
use App\Shared\Infrastructure\Requests\SortedAndPaginatedRequest;
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
