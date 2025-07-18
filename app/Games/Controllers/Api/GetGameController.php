<?php

declare(strict_types=1);

namespace App\Games\Controllers\Api;

use App\Games\Models\Game;
use App\Games\Queries\GetAllGamesQuery;
use App\Games\Queries\GetAllGamesWithoutRequestedCategoryQuery;
use App\Games\Queries\GetGameQuery;
use App\Games\Queries\GetGamesQuery;
use App\Games\Queries\GetGameWithCategoriesAndPlayableItemsQuery;
use App\Games\Repositories\GameRepositoryInterface;
use App\Games\Requests\AllGamesWithoutRequestedCategoryRequest;
use App\Games\Services\GameQueriesService;
use App\Helpers\RequestHelper;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Http\Exceptions\HttpExceptionInterface;
use App\Shared\SortAndPagination\Builders\DtosWithPaginationDtoBuilder;
use App\Shared\SortAndPagination\Dtos\SortedAndPaginatedDto;
use App\Shared\SortAndPagination\Requests\SortedAndPaginatedRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class GetGameController
{
    /** @param DtosWithPaginationDtoBuilder<Game> $dtosWithPaginationDtoBuilder */
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
                message: 'Games were not successfully retrieved.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'Games were successfully retrieved.', content: $result);
    }

    public function getAllGames(Request $request): JsonResponse
    {
        try {
            $query = new GetAllGamesQuery(
                gameRepository: $this->gameRepository,
                gameQueriesService: $this->gameQueriesService,
                userId: RequestHelper::getUserId($request)
            );
            $result = $query->get();
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'All games were successfully retrieved.', content: $result);
    }

    public function getAllGamesWithoutRequestedCategory(AllGamesWithoutRequestedCategoryRequest $request): JsonResponse
    {
        try {
            /** @var array{'categoryId': string} $validated */
            $validated = $request->validated();

            $query = new GetAllGamesWithoutRequestedCategoryQuery(
                gameRepository: $this->gameRepository,
                gameQueriesService: $this->gameQueriesService,
                userId: RequestHelper::getUserId($request),
                categoryId: $validated['categoryId']
            );
            $result = $query->get();
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'All Games without requested category were successfully retrieved.', content: $result);
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
            return $this->apiController->sendUncaughtThrowable($e);
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
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'Game was successfully retrieved.', content: $result);
    }
}
