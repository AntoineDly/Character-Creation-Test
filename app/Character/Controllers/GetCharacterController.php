<?php

declare(strict_types=1);

namespace App\Character\Controllers;

use App\Base\Controllers\ApiController\ApiControllerInterface;
use App\Character\Builders\CharacterDtoBuilder;
use App\Character\Queries\GetCharacterQuery;
use App\Character\Queries\GetCharactersQuery;
use App\Character\Repositories\CharacterRepository\CharacterRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

final class GetCharacterController extends Controller
{
    public function __construct(
        private CharacterRepository $characterRepository,
        private CharacterDtoBuilder $characterDtoBuilder,
        private ApiControllerInterface $apiController,
    ) {
    }

    public function getCharacters(): JsonResponse
    {
        try {
            $query = new GetCharactersQuery(
                characterRepository: $this->characterRepository,
                characterDtoBuilder: $this->characterDtoBuilder,
            );
            $result = $query->get();
        } catch (Exception $e) {
            return $this->apiController->sendError(error: $e->getMessage());
        }

        return $this->apiController->sendSuccess(message: 'Characters were successfully retrieved', content: [$result]);
    }

    public function getCharacter(string $characterId): JsonResponse
    {
        try {
            $query = new GetCharacterQuery(
                characterRepository: $this->characterRepository,
                characterDtoBuilder: $this->characterDtoBuilder,
                characterId: $characterId
            );
            $result = $query->get();
        } catch (Exception $e) {
            return $this->apiController->sendError(error: $e->getMessage());
        }

        return $this->apiController->sendSuccess(message: 'Character was successfully retrieved', content: [$result]);
    }
}
