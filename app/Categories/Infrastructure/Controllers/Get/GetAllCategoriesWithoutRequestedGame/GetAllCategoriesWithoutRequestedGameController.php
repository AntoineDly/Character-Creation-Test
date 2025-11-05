<?php

declare(strict_types=1);

namespace App\Categories\Infrastructure\Controllers\Get\GetAllCategoriesWithoutRequestedGame;

use App\Categories\Application\Queries\GetAllCategoriesWithoutRequestedGameQuery\GetAllCategoriesWithoutRequestedGameQuery;
use App\Helpers\RequestHelper;
use App\Shared\Application\Queries\QueryBus;
use App\Shared\Infrastructure\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Infrastructure\Http\Exceptions\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Throwable;

final readonly class GetAllCategoriesWithoutRequestedGameController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private QueryBus $queryBus,
    ) {
    }

    public function __invoke(GetAllCategoriesWithoutRequestedGameRequest $request): JsonResponse
    {
        try {
            /** @var array{'gameId': string} $validated */
            $validated = $request->validated();

            $query = new GetAllCategoriesWithoutRequestedGameQuery(
                userId: RequestHelper::getUserId($request),
                gameId: $validated['gameId']
            );
            $result = $this->queryBus->dispatch($query);
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'All Categories without requested game were successfully retrieved.', content: $result);
    }
}
