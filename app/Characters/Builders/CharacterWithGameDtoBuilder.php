<?php

declare(strict_types=1);

namespace App\Characters\Builders;

use App\Characters\Dtos\CharacterWithGameDto;
use App\Games\Dtos\GameDto;
use App\Games\Exceptions\GameNotFoundException;
use App\Helpers\UuidHelper;
use App\Shared\Builders\BuilderInterface;
use App\Shared\Http\Exceptions\NotAValidUuidException;

final class CharacterWithGameDtoBuilder implements BuilderInterface
{
    private string $id;

    private ?GameDto $gameDto = null;

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function setGameDto(GameDto $gameDto): static
    {
        $this->gameDto = $gameDto;

        return $this;
    }

    /**
     * @throws GameNotFoundException
     * @throws NotAValidUuidException
     */
    public function build(): CharacterWithGameDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException(data: ['value' => $this->id]);
        }

        if (! $this->gameDto instanceof GameDto) {
            throw new GameNotFoundException('Game was not found to create the CharacterWithGameDto');
        }

        $characterDto = new CharacterWithGameDto(
            id: $this->id,
            gameDto: $this->gameDto
        );

        $this->id = '';
        $this->gameDto = null;

        return $characterDto;
    }
}
