<?php

declare(strict_types=1);

namespace App\Characters\Controllers;

use App\Characters\Queries\GetCharacterQuery;
use App\Characters\Queries\GetCharactersQuery;
use App\Characters\Queries\GetCharactersWithGameQuery;
use App\Characters\Queries\GetCharacterWithGameQuery;
use App\Characters\Repositories\CharacterRepositoryInterface;
use App\Characters\Services\CharacterQueriesService;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use Exception;
use Illuminate\Http\JsonResponse;

final readonly class GetCharacterController
{
    public function __construct(
        private CharacterRepositoryInterface $characterRepository,
        private CharacterQueriesService $characterQueriesService,
        private ApiControllerInterface $apiController,
    ) {
    }

    public function getCharacters(): JsonResponse
    {
        try {
            $query = new GetCharactersQuery(
                characterRepository: $this->characterRepository,
                characterQueriesService: $this->characterQueriesService,
            );
            $result = $query->get();
        } catch (Exception $e) {
            return $this->apiController->sendException(exception: $e);
        }

        return $this->apiController->sendSuccess(message: 'Characters were successfully retrieved', content: [$result]);
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
        } catch (Exception $e) {
            return $this->apiController->sendException(exception: $e);
        }

        return $this->apiController->sendSuccess(message: 'Character was successfully retrieved', content: [$result]);
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
        } catch (Exception $e) {
            return $this->apiController->sendException(exception: $e);
        }

        return $this->apiController->sendSuccess(message: 'Character was successfully retrieved', content: [$result]);
    }

    public function getCharactersWithGame(): JsonResponse
    {
        try {
            $query = new GetCharactersWithGameQuery(
                characterRepository: $this->characterRepository,
                characterQueriesService: $this->characterQueriesService,
            );
            $result = $query->get();
        } catch (Exception $e) {
            return $this->apiController->sendException(exception: $e);
        }

        return $this->apiController->sendSuccess(message: 'Character was successfully retrieved', content: [$result]);
    }
}
