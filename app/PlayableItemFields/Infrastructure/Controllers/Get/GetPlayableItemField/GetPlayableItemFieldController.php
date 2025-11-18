<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Infrastructure\Controllers\Get\GetPlayableItemField;

use App\PlayableItemFields\Application\Queries\GetPlayableItemFieldQuery\GetPlayableItemFieldQuery;
use App\Shared\Application\Queries\QueryBus;
use App\Shared\Infrastructure\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Infrastructure\Http\Exceptions\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Throwable;

final readonly class GetPlayableItemFieldController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private QueryBus $queryBus,
    ) {
    }

    public function __invoke(string $playableItemFieldId): JsonResponse
    {
        try {
            $query = new GetPlayableItemFieldQuery(
                playableItemFieldId: $playableItemFieldId
            );
            $result = $this->queryBus->dispatch($query);
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'Playable ItemField was successfully retrieved.', content: $result);
    }
}
