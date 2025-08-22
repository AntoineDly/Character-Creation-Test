<?php

declare(strict_types=1);

namespace App\Characters\Domain\Dtos\CharacterDto;

use App\Helpers\UuidHelper;
use App\Shared\Dtos\BuilderInterface;
use App\Shared\Http\Exceptions\NotAValidUuidException;

final class CharacterDtoBuilder implements BuilderInterface
{
    private string $id = '';

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function build(): CharacterDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException(data: ['value' => $this->id]);
        }

        $characterDto = new CharacterDto(
            id: $this->id
        );

        $this->id = '';

        return $characterDto;
    }
}
