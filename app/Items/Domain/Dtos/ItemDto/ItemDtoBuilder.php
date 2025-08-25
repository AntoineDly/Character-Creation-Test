<?php

declare(strict_types=1);

namespace App\Items\Domain\Dtos\ItemDto;

use App\Helpers\UuidHelper;
use App\Shared\Domain\Dtos\BuilderInterface;
use App\Shared\Infrastructure\Http\Exceptions\NotAValidUuidException;

final class ItemDtoBuilder implements BuilderInterface
{
    private string $id = '';

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function build(): ItemDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException(data: ['value' => $this->id]);
        }

        $itemDto = new ItemDto(
            id: $this->id,
        );

        $this->id = '';

        return $itemDto;
    }
}
