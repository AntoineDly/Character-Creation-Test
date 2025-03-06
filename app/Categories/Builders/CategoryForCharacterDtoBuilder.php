<?php

declare(strict_types=1);

namespace App\Categories\Builders;

use App\Categories\Dtos\CategoryForCharacterDto;
use App\Helpers\UuidHelper;
use App\LinkedItems\Dtos\LinkedItemForCharacterDto;
use App\Shared\Builders\BuilderInterface;
use App\Shared\Exceptions\Http\NotAValidUuidException;
use App\Shared\Exceptions\Http\StringIsEmptyException;

final class CategoryForCharacterDtoBuilder implements BuilderInterface
{
    private string $id = '';

    private string $name = '';

    /** @var LinkedItemForCharacterDto[] */
    private array $linkedItemForCharacterDtos = [];

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

    public function addLinkedItemsForCharacterDto(LinkedItemForCharacterDto $linkedItemsForCharacterDto): self
    {
        $this->linkedItemForCharacterDtos[] = $linkedItemsForCharacterDto;

        return $this;
    }

    /** @param LinkedItemForCharacterDto[] $linkedItemForCharacterDtos */
    public function setLinkedItemForCharacterDtos(array $linkedItemForCharacterDtos): self
    {
        $this->linkedItemForCharacterDtos = $linkedItemForCharacterDtos;

        return $this;
    }

    public function build(): CategoryForCharacterDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException(data: ['value' => $this->id]);
        }

        if ($this->name === '') {
            throw new StringIsEmptyException(data: ['field' => 'name']);
        }

        $categoryForCharacterDto = new CategoryForCharacterDto(
            id: $this->id,
            name: $this->name,
            linkedItemForCharacterDtos: $this->linkedItemForCharacterDtos
        );

        $this->id = $this->name = '';
        $this->linkedItemForCharacterDtos = [];

        return $categoryForCharacterDto;
    }
}
