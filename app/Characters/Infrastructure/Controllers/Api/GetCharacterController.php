<?php

declare(strict_types=1);

namespace App\Characters\Infrastructure\Controllers\Api;

use App\Characters\Application\Queries\GetCharacterQuery\GetCharacterQuery;
use App\Characters\Application\Queries\GetCharactersQuery\GetCharactersQuery;
use App\Characters\Application\Queries\GetCharactersWithGameQuery\GetCharactersWithGameQuery;
use App\Characters\Application\Queries\GetCharacterWithGameQuery\GetCharacterWithGameQuery;
use App\Characters\Application\Queries\GetCharacterWithLinkedItemsQuery\GetCharacterWithLinkedItemsQuery;
use App\Shared\Application\Queries\QueryBus;
use App\Shared\Domain\SortAndPagination\Dtos\SortedAndPaginatedDto\SortedAndPaginatedDto;
use App\Shared\Infrastructure\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Infrastructure\Http\Exceptions\HttpExceptionInterface;
use App\Shared\Infrastructure\Requests\SortedAndPaginatedRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class GetCharacterController
{
    public function __construct(
        private ApiControllerInterface $apiController,
        private QueryBus $queryBus,
    ) {
    }

    public function getCharacters(SortedAndPaginatedRequest $request): JsonResponse
    {
        try {
            $sortedAndPaginatedDto = SortedAndPaginatedDto::fromSortedAndPaginatedRequest($request);

            $query = new GetCharactersQuery(
                sortedAndPaginatedDto: $sortedAndPaginatedDto,
            );
            $result = $this->queryBus->dispatch($query);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Characters were not successfully retrieved.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'Characters were successfully retrieved.', content: $result);
    }

    public function getCharacter(string $characterId): JsonResponse
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

    public function getCharacterWithGame(string $characterId): JsonResponse
    {
        try {
            $query = new GetCharacterWithGameQuery(
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

    public function getCharactersWithGame(SortedAndPaginatedRequest $request): JsonResponse
    {
        try {
            $sortedAndPaginatedDto = SortedAndPaginatedDto::fromSortedAndPaginatedRequest($request);

            $query = new GetCharactersWithGameQuery(
                sortedAndPaginatedDto: $sortedAndPaginatedDto,

            );
            $result = $this->queryBus->dispatch($query);
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Characters were not successfully retrieved.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendUncaughtThrowable($e);
        }

        return $this->apiController->sendSuccess(message: 'Characters were successfully retrieved.', content: $result);
    }

    public function getCharacterWithLinkedItems(string $characterId): JsonResponse
    {
        try {
            $query = new GetCharacterWithLinkedItemsQuery(
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
