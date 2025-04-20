<?php

declare(strict_types=1);

namespace App\Parameters\Builders;

use App\Helpers\UuidHelper;
use App\Parameters\Dtos\ParameterDto;
use App\Parameters\Enums\TypeParameterEnum;
use App\Shared\Builders\BuilderInterface;
use App\Shared\Http\Exceptions\InvalidTypeParameterException;
use App\Shared\Http\Exceptions\NotAValidUuidException;
use App\Shared\Http\Exceptions\StringIsEmptyException;

final class ParameterDtoBuilder implements BuilderInterface
{
    private string $id = '';

    private string $name = '';

    private ?TypeParameterEnum $type = null;

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function setType(?TypeParameterEnum $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function build(): ParameterDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException(data: ['value' => $this->id]);
        }

        if ($this->name === '') {
            throw new StringIsEmptyException(data: ['field' => 'name']);
        }

        if (! $this->type instanceof TypeParameterEnum) {
            throw new InvalidTypeParameterException(data: ['expectedType' => TypeParameterEnum::class, 'currentType' => gettype($this->type)]);
        }

        $parameterDto = new ParameterDto(
            id: $this->id,
            name: $this->name,
            type: $this->type->value
        );

        $this->id = $this->name = '';
        $this->type = null;

        return $parameterDto;
    }
}
