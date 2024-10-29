<?php

declare(strict_types=1);

namespace App\Parameters\Builders;

use App\Helpers\UuidHelper;
use App\Parameters\Dtos\ParameterDto;
use App\Parameters\Enums\TypeParameterEnum;
use App\Shared\Builders\BuilderInterface;
use App\Shared\Exceptions\Http\InvalidTypeParameterException;
use App\Shared\Exceptions\Http\NotAValidUuidException;
use App\Shared\Exceptions\Http\StringIsEmptyException;

final class ParameterDtoBuilder implements BuilderInterface
{
    private string $id = '';

    private string $name = '';

    private ?TypeParameterEnum $type = null;

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

    public function setType(?TypeParameterEnum $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function build(): ParameterDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException('id field is not a valid uuid, '.$this->id.' given.');
        }

        if ($this->name === '') {
            throw new StringIsEmptyException('name field is empty');
        }

        if (! $this->type instanceof TypeParameterEnum) {
            throw new InvalidTypeParameterException('type should be an instance of TypeParameterEnum but is null');
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
