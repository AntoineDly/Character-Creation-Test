<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Controllers\Api;

use App\PlayableItemFields\Queries\GetPlayableItemFieldQuery;
use App\PlayableItemFields\Queries\GetPlayableItemFieldsQuery;
use App\PlayableItemFields\Repositories\PlayableItemFieldRepositoryInterface;
use App\PlayableItemFields\Services\PlayableItemFieldQueriesService;
use App\Shared\Builders\DtosWithPaginationDtoBuilder;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Dtos\SortedAndPaginatedDto;
use App\Shared\Exceptions\Http\HttpExceptionInterface;
use App\Shared\Requests\SortedAndPaginatedRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class GetPlayableItemFieldsController
{
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
            /** @var array{'sortOrder': string, 'perPage': int, 'page': int} $validatedData */
            $validatedData = $request->validated();
            $sortedAndPaginatedDto = SortedAndPaginatedDto::fromArray($validatedData);

            $query = new GetPlayableItemFieldsQuery(
                playableItemFieldRepository: $this->playableItemFieldRepository,
                playableItemFieldQueriesService: $this->playableItemFieldQueriesService,
                dtosWithPaginationDtoBuilder: $this->dtosWithPaginationDtoBuilder,
                sortedAndPaginatedDto: $sortedAndPaginatedDto,
            );
            $result = $query->get();
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Playable Items Fields were not successfully retrieved.',
                e: $e
            );
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
