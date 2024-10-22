<?php

declare(strict_types=1);

namespace App\Characters\Builders;

use App\Characters\Dtos\CharacterWithGameDto;
use App\Games\Dtos\GameDto;
use App\Games\Exceptions\GameNotFoundException;
use App\Helpers\UuidHelper;
use App\Shared\Builders\BuilderInterface;
use App\Shared\Exceptions\Http\NotAValidUuidException;

final class CharacterWithGameDtoBuilder implements BuilderInterface
{
    private string $id;

    private ?GameDto $gameDto = null;

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setGameDto(GameDto $gameDto): self
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
            throw new NotAValidUuidException('id field is not a valid uuid, '.$this->id.' given.');
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
