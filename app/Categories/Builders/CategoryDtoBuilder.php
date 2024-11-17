<?php

declare(strict_types=1);

namespace App\Categories\Builders;

use App\Categories\Dtos\CategoryDto;
use App\Helpers\UuidHelper;
use App\Shared\Builders\BuilderInterface;
use App\Shared\Exceptions\Http\NotAValidUuidException;
use App\Shared\Exceptions\Http\StringIsEmptyException;

final class CategoryDtoBuilder implements BuilderInterface
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

    public function build(): CategoryDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException(data: ['value' => $this->id]);
        }

        if ($this->name === '') {
            throw new StringIsEmptyException(data: ['field' => 'name']);
        }

        $categoryDto = new CategoryDto(
            id: $this->id,
            name: $this->name
        );

        $this->id = $this->name = '';

        return $categoryDto;
    }
}
