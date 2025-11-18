<?php

declare(strict_types=1);

namespace App\Games\Infrastructure\Controllers\Get\GetAllGamesWithoutRequestedCategory;

use App\Games\Application\Queries\GetAllGamesWithoutRequestedCategoryQuery\GetAllGamesWithoutRequestedCategoryQuery;
use App\Helpers\RequestHelper;
use App\Shared\Application\Queries\QueryBus;
use App\Shared\Infrastructure\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Infrastructure\Http\Exceptions\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Throwable;

final readonly class GetAllGamesWithoutRequestedCategoryController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private QueryBus $queryBus,
    ) {
    }

    public function __invoke(AllGamesWithoutRequestedCategoryRequest $request): JsonResponse
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
}
