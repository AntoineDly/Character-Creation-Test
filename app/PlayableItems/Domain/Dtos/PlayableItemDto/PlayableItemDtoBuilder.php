<?php

declare(strict_types=1);

namespace App\PlayableItems\Domain\Dtos\PlayableItemDto;

use App\Helpers\UuidHelper;
use App\Shared\Domain\Dtos\BuilderInterface;
use App\Shared\Infrastructure\Http\Exceptions\NotAValidUuidException;

final class PlayableItemDtoBuilder implements BuilderInterface
{
    private string $id = '';

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function build(): PlayableItemDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException(data: ['value' => $this->id]);
        }

        $playableItemDto = new PlayableItemDto(
            id: $this->id
        );

        $this->id = '';

        return $playableItemDto;
    }
}
