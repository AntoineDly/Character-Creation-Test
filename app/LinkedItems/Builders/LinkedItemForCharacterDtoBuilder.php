<?php

declare(strict_types=1);

namespace App\LinkedItems\Builders;

use App\Helpers\UuidHelper;
use App\LinkedItems\Dtos\LinkedItemForCharacterDto;
use App\Shared\Builders\BuilderInterface;
use App\Shared\Fields\Collection\FieldDtoCollection;
use App\Shared\Http\Exceptions\NotAValidUuidException;

final class LinkedItemForCharacterDtoBuilder implements BuilderInterface
{
    private string $id = '';

    private FieldDtoCollection $fieldDtoCollection;

    public function __construct()
    {
        $this->fieldDtoCollection = new FieldDtoCollection();
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function setFieldDtoCollection(FieldDtoCollection $fieldDtoCollection): static
    {
        $this->fieldDtoCollection = $fieldDtoCollection;

        return $this;
    }

    public function build(): LinkedItemForCharacterDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException(data: ['value' => $this->id]);
        }

        $linkedItemForCharacterDto = new LinkedItemForCharacterDto(
            id: $this->id,
            fieldDtoCollection: $this->fieldDtoCollection
        );

        $this->id = '';
        $this->fieldDtoCollection = new FieldDtoCollection();

        return $linkedItemForCharacterDto;
    }
}
