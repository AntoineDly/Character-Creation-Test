<?php

declare(strict_types=1);

namespace App\Characters\Infrastructure\Controllers\Get\GetCharacter;

use App\Characters\Application\Queries\GetCharacterQuery\GetCharacterQuery;
use App\Shared\Application\Queries\QueryBus;
use App\Shared\Infrastructure\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Infrastructure\Http\Exceptions\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;
use Throwable;

final readonly class GetCharacterController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private QueryBus $queryBus,
    ) {
    }

    public function __invoke(string $characterId): JsonResponse
    {
        try {
            $query = new GetCharacterQuery(
                characterId: $characterId
            );
            $result = $this->queryBus->dispatch($query);
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'Character was successfully retrieved.', content: $result);
    }
}
