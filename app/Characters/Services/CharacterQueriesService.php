<?php

declare(strict_types=1);

namespace App\Characters\Services;

use App\Characters\Builders\CharacterDtoBuilder;
use App\Characters\Builders\CharacterWithGameDtoBuilder;
use App\Characters\Dtos\CharacterDto;
use App\Characters\Dtos\CharacterWithGameDto;
use App\Characters\Exceptions\CharacterNotFoundException;
use App\Characters\Models\Character;
use App\Games\Repositories\GameRepositoryInterface;
use App\Games\Services\GameQueriesService;
use App\Shared\Exceptions\InvalidClassException;
use Illuminate\Database\Eloquent\Model;

final readonly class CharacterQueriesService
{
    public function __construct(
        private CharacterDtoBuilder $characterDtoBuilder,
        private CharacterWithGameDtoBuilder $characterWithGameDtoBuilder,
        private GameRepositoryInterface $gameRepository,
        private GameQueriesService $gameQueriesService
    ) {
    }

    public function getCharacterDtoFromModel(?Model $character): CharacterDto
    {
        if (is_null($character)) {
            throw new CharacterNotFoundException(message: 'Character not found', code: 404);
        }

        if (! $character instanceof Character) {
            throw new InvalidClassException(
                'Class was expected to be Character, '.get_class($character).' given.'
            );
        }

        /** @var array{'id': string, 'name': string} $characterData */
        $characterData = $character->toArray();

        return $this->characterDtoBuilder
            ->setId(id: $characterData['id'])
            ->setName(name: $characterData['name'])
            ->build();
    }

    public function getCharacterWithGameDtoFromModel(?Model $character): CharacterWithGameDto
    {
        if (is_null($character)) {
            throw new CharacterNotFoundException(message: 'Character not found', code: 404);
        }

        if (! $character instanceof Character) {
            throw new InvalidClassException(
                'Class was expected to be Character, '.get_class($character).' given.'
            );
        }

        /** @var array{'id': string, 'name': string, 'game_id': string} $characterData */
        $characterData = $character->toArray();

        $game = $this->gameRepository->findById(id: $characterData['game_id']);
        $gameDto = $this->gameQueriesService->getGameDtoFromModel($game);

        return $this->characterWithGameDtoBuilder
            ->setId(id: $characterData['id'])
            ->setName(name: $characterData['name'])
            ->setGameDto(gameDto: $gameDto)
            ->build();
    }
}
