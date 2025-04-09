<?php

declare(strict_types=1);

namespace App\Characters\Controllers\Api;

use App\Characters\Queries\GetCharacterQuery;
use App\Characters\Queries\GetCharactersQuery;
use App\Characters\Queries\GetCharactersWithGameQuery;
use App\Characters\Queries\GetCharacterWithGameQuery;
use App\Characters\Queries\GetCharacterWithLinkedItemsQuery;
use App\Characters\Repositories\CharacterRepositoryInterface;
use App\Characters\Services\CharacterQueriesService;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use App\Shared\Dtos\SortedAndPaginatedDto;
use App\Shared\Exceptions\Http\HttpExceptionInterface;
use App\Shared\Requests\SortedAndPaginatedRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

final readonly class GetCharacterController
{
    public function __construct(
        private CharacterRepositoryInterface $characterRepository,
        private CharacterQueriesService $characterQueriesService,
        private ApiControllerInterface $apiController,
    ) {
    }

    public function getCharacters(SortedAndPaginatedRequest $request): JsonResponse
    {
        try {
            /** @var array{'sortOrder': string, 'perPage': int, 'page': int} $validatedData */
            $validatedData = $request->validated();
            $sortedAndPaginatedDto = SortedAndPaginatedDto::fromArray($validatedData);

            $query = new GetCharactersQuery(
                characterRepository: $this->characterRepository,
                characterQueriesService: $this->characterQueriesService,
                sortedAndPaginatedDto: $sortedAndPaginatedDto,
            );
            $result = $query->get();
        } catch (ValidationException $e) {
            return $this->apiController->sendExceptionFromLaravelValidationException(
                message: 'Characters were not successfully retrieved.',
                e: $e
            );
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Characters were successfully retrieved.', content: $result);
    }

    public function getCharacter(string $characterId): JsonResponse
    {
        try {
            $query = new GetCharacterQuery(
                characterRepository: $this->characterRepository,
                characterQueriesService: $this->characterQueriesService,
                characterId: $characterId
            );
            $result = $query->get();
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Character was successfully retrieved.', content: $result);
    }

    public function getCharacterWithGame(string $characterId): JsonResponse
    {
        try {
            $query = new GetCharacterWithGameQuery(
                characterRepository: $this->characterRepository,
                characterQueriesService: $this->characterQueriesService,
                characterId: $characterId
            );
            $result = $query->get();
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Character was successfully retrieved.', content: $result);
    }

    public function getCharactersWithGame(): JsonResponse
    {
        try {
            $query = new GetCharactersWithGameQuery(
                characterRepository: $this->characterRepository,
                characterQueriesService: $this->characterQueriesService,
            );
            $result = $query->get();
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Character was successfully retrieved.', content: $result);
    }

    public function getCharacterWithLinkedItems(string $characterId): JsonResponse
    {
        try {
            $query = new GetCharacterWithLinkedItemsQuery(
                characterRepository: $this->characterRepository,
                characterQueriesService: $this->characterQueriesService,
                characterId: $characterId
            );
            $result = $query->get();
        } catch (HttpExceptionInterface $e) {
            return $this->apiController->sendException($e);
        } catch (Throwable $e) {
            return $this->apiController->sendExceptionNotCatch($e);
        }

        return $this->apiController->sendSuccess(message: 'Character was successfully retrieved.', content: $result);
    }
}
