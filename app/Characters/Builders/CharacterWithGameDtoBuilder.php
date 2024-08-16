<?php

declare(strict_types=1);

namespace App\Characters\Builders;

use App\Characters\Dtos\CharacterWithGameDto;
use App\Games\Dtos\GameDto;
use App\Games\Exceptions\GameNotFoundException;
use App\Helpers\UuidHelper;
use App\Shared\Builders\BuilderInterface;
use App\Shared\Exceptions\NotAValidUuidException;
use App\Shared\Exceptions\StringIsEmptyException;

final class CharacterWithGameDtoBuilder implements BuilderInterface
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
            throw new NotAValidUuidException('id field is not a valid uuid, '.$this->id.' given.', code: 400);
        }

        if ($this->name === '') {
            throw new StringIsEmptyException('name field is empty', code: 400);
        }

        if (! $this->gameDto instanceof GameDto) {
            throw new GameNotFoundException('Game was not found to create the CharacterWithGameDto', code: 400);
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
