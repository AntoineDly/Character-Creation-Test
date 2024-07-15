<?php

declare(strict_types=1);

namespace App\Character\Builders;

use App\Base\Exceptions\NotAValidUuidException;
use App\Base\Exceptions\StringIsEmptyException;
use App\Character\Dtos\CharacterWithGameDto;
use App\Game\Dtos\GameDto;
use App\Game\Exceptions\GameNotFoundException;
use App\Helpers\UuidHelper;

final class CharacterWithGameDtoBuilder
{
    public string $id;

    public string $name;

    public ?GameDto $gameDto = null;

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setGameDto(GameDto $gameDto): self
    {
        $this->gameDto = $gameDto;

        return $this;
    }

    public function build(): CharacterWithGameDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException('id field is not a valid uuid, '.$this->id.' given.');
        }

        if ($this->name === '') {
            throw new StringIsEmptyException('name field is empty');
        }

        if (! $this->gameDto instanceof GameDto) {
            throw new GameNotFoundException('Game was not found to create the CharacterWithGameDto');
        }

        $characterDto = new CharacterWithGameDto(
            id: $this->id,
            name: $this->name,
            gameDto: $this->gameDto
        );

        $this->id = $this->name = '';
        $this->gameDto = null;

        return $characterDto;
    }
}
