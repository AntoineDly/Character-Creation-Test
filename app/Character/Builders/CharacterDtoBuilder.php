<?php

declare(strict_types=1);

namespace App\Character\Builders;

use App\Base\Exceptions\NotAValidUuidException;
use App\Base\Exceptions\StringIsEmptyException;
use App\Character\Dtos\CharacterDto;
use App\Helpers\UuidHelper;

final class CharacterDtoBuilder
{
    public string $id = '';

    public string $name = '';

    public function setId(string $id): CharacterDtoBuilder
    {
        $this->id = $id;

        return $this;
    }

    public function setName(string $name): CharacterDtoBuilder
    {
        $this->name = $name;

        return $this;
    }

    public function build(): CharacterDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException('id field is not a valid uuid, '.$this->id.' given.');
        }

        if ($this->name === '') {
            throw new StringIsEmptyException('name field is empty');
        }

        $characterDto = new CharacterDto(
            id: $this->id,
            name: $this->name
        );

        $this->id = $this->name = '';

        return $characterDto;
    }
}
