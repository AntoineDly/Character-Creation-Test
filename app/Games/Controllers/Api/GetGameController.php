<?php

declare(strict_types=1);

namespace App\Games\Controllers\Api;

use App\Games\Queries\GetGameQuery;
use App\Games\Queries\GetGamesQuery;
use App\Games\Queries\GetGameWithCategoriesAndPlayableItemsQuery;
use App\Games\Repositories\GameRepositoryInterface;
use App\Games\Services\GameQueriesService;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Http\Exceptions\HttpExceptionInterface;
use App\Shared\SortAndPagination\Builders\DtosWithPaginationDtoBuilder;
use App\Shared\SortAndPagination\Dtos\SortedAndPaginatedDto;
use App\Shared\SortAndPagination\Requests\SortedAndPaginatedRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class GetGameController
{
    public function __construct(
        private GameRepositoryInterface $gameRepository,
        private GameQueriesService $gameQueriesService,
        private ApiControllerInterface $apiController,
        private DtosWithPaginationDtoBuilder $dtosWithPaginationDtoBuilder,
    ) {
    }

    public function getGames(SortedAndPaginatedRequest $request): JsonResponse
    {
        try {
            $sortedAndPaginatedDto = SortedAndPaginatedDto::fromSortedAndPaginatedRequest($request);

            $query = new GetGamesQuery(
                gameRepository: $this->gameRepository,
                gameQueriesService: $this->gameQueriesService,
                sortedAndPaginatedDto: $sortedAndPaginatedDto,
                dtosWithPaginationDtoBuilder: $this->dtosWithPaginationDtoBuilder,
            );
            $result = $query->get();
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Games  were not successfully retrieved.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Games were successfully retrieved.', content: $result);
    }

    public function getGame(string $gameId): JsonResponse
    {
        try {
            $query = new GetGameQuery(
                gameRepository: $this->gameRepository,
                gameQueriesService: $this->gameQueriesService,
                gameId: $gameId
            );
            $result = $query->get();
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Game was successfully retrieved.', content: $result);
    }

    public function getGameWithCategoriesAndPlayableItems(string $gameId): JsonResponse
    {
        try {
            $query = new GetGameWithCategoriesAndPlayableItemsQuery(
                gameRepository: $this->gameRepository,
                gameQueriesService: $this->gameQueriesService,
                gameId: $gameId
            );
            $result = $query->get();
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Game was successfully retrieved.', content: $result);
    }
}
