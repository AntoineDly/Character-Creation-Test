<?php

declare(strict_types=1);

namespace App\Categories\Builders;

use App\Base\Exceptions\NotAValidUuidException;
use App\Base\Exceptions\StringIsEmptyException;
use App\Categories\Dtos\CategoryDto;
use App\Helpers\UuidHelper;

final class CategoryDtoBuilder
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

    public function build(): CategoryDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException('id field is not a valid uuid, '.$this->id.' given.', code: 400);
        }

        if ($this->name === '') {
            throw new StringIsEmptyException('name field is empty', code: 400);
        }

        $categoryDto = new CategoryDto(
            id: $this->id,
            name: $this->name
        );

        $this->id = $this->name = '';

        return $categoryDto;
    }
}
