<?php

declare(strict_types=1);

namespace App\Games\Infrastructure\Controllers\Api;

use App\Games\Application\Queries\GetAllGamesQuery\GetAllGamesQuery;
use App\Games\Application\Queries\GetAllGamesWithoutRequestedCategoryQuery\GetAllGamesWithoutRequestedCategoryQuery;
use App\Games\Application\Queries\GetGameQuery\GetGameQuery;
use App\Games\Application\Queries\GetGamesQuery\GetGamesQuery;
use App\Games\Application\Queries\GetGameWithCategoriesAndPlayableItemsQuery\GetGameWithCategoriesAndPlayableItemsQuery;
use App\Games\Infrastructure\Requests\AllGamesWithoutRequestedCategoryRequest;
use App\Helpers\RequestHelper;
use App\Shared\Application\Queries\QueryBus;
use App\Shared\Domain\SortAndPagination\Dtos\SortedAndPaginatedDto\SortedAndPaginatedDto;
use App\Shared\Infrastructure\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Infrastructure\Http\Exceptions\HttpExceptionInterface;
use App\Shared\Infrastructure\Requests\SortedAndPaginatedRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class GetGameController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private QueryBus $queryBus,
    ) {
    }

    public function getGames(SortedAndPaginatedRequest $request): JsonResponse
    {
        try {
            $sortedAndPaginatedDto = SortedAndPaginatedDto::fromSortedAndPaginatedRequest($request);

            $query = new GetGamesQuery(
                sortedAndPaginatedDto: $sortedAndPaginatedDto,
            );
            $result = $this->queryBus->dispatch($query);
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
                userId: RequestHelper::getUserId($request)
            );
            $result = $this->queryBus->dispatch($query);
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
                userId: RequestHelper::getUserId($request),
                categoryId: $validated['categoryId']
            );
            $result = $this->queryBus->dispatch($query);
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
                gameId: $gameId
            );
            $result = $this->queryBus->dispatch($query);
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
                gameId: $gameId
            );
            $result = $this->queryBus->dispatch($query);
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'Game was successfully retrieved.', content: $result);
    }
}
