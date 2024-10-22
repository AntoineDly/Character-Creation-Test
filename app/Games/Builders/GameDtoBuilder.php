<?php

declare(strict_types=1);

namespace App\Games\Builders;

use App\Games\Dtos\GameDto;
use App\Helpers\UuidHelper;
use App\Shared\Builders\BuilderInterface;
use App\Shared\Exceptions\Http\NotAValidUuidException;
use App\Shared\Exceptions\Http\StringIsEmptyException;

final class GameDtoBuilder implements BuilderInterface
{
    private string $id = '';

    private string $name = '';

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

    public function build(): GameDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException('id field is not a valid uuid, '.$this->id.' given.');
        }

        if ($this->name === '') {
            throw new StringIsEmptyException('name field is empty');
        }

        $gameDto = new GameDto(
            id: $this->id,
            name: $this->name
        );

        $this->id = $this->name = '';

        return $gameDto;
    }
}
