<?php

declare(strict_types=1);

namespace App\Items\Builders;

use App\Helpers\UuidHelper;
use App\Items\Dtos\ItemDto;
use App\Shared\Builders\BuilderInterface;
use App\Shared\Exceptions\NotAValidUuidException;
use App\Shared\Exceptions\StringIsEmptyException;

final class ItemDtoBuilder implements BuilderInterface
{
    public string $id = '';

    public string $name = '';

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

    public function build(): ItemDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException('id field is not a valid uuid, '.$this->id.' given.', code: 400);
        }

        if ($this->name === '') {
            throw new StringIsEmptyException('name field is empty', code: 400);
        }

        $itemDto = new ItemDto(
            id: $this->id,
            name: $this->name
        );

        $this->id = $this->name = '';

        return $itemDto;
    }
}
