<?php

declare(strict_types=1);

namespace App\PlayableItems\Infrastructure\Controllers\Get\GetPlayableItem;

use App\PlayableItems\Application\Queries\GetPlayableItemQuery\GetPlayableItemQuery;
use App\Shared\Application\Queries\QueryBus;
use App\Shared\Infrastructure\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Infrastructure\Http\Exceptions\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Throwable;

final readonly class GetPlayableItemController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private QueryBus $queryBus,
    ) {
    }

    public function __invoke(string $playableItemId): JsonResponse
    {
        try {
            $query = new GetPlayableItemQuery(
                playableItemId: $playableItemId
            );
            $result = $this->queryBus->dispatch($query);
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'Playable Item was successfully retrieved.', content: $result);
    }
}
