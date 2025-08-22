<?php

declare(strict_types=1);

namespace App\Categories\Domain\Dtos\CategoryForCharacterDto;

use App\Helpers\UuidHelper;
use App\LinkedItems\Domain\Dtos\LinkedItemForCharacterDto\LinkedItemForCharacterDto;
use App\Shared\Dtos\BuilderInterface;
use App\Shared\Http\Exceptions\NotAValidUuidException;
use App\Shared\Http\Exceptions\StringIsEmptyException;

final class CategoryForCharacterDtoBuilder implements BuilderInterface
{
    private string $id = '';

    private string $name = '';

    /** @var LinkedItemForCharacterDto[] */
    private array $linkedItemForCharacterDtos = [];

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

    public function addLinkedItemsForCharacterDto(LinkedItemForCharacterDto $linkedItemsForCharacterDto): static
    {
        $this->linkedItemForCharacterDtos[] = $linkedItemsForCharacterDto;

        return $this;
    }

    /** @param LinkedItemForCharacterDto[] $linkedItemForCharacterDtos */
    public function setLinkedItemForCharacterDtos(array $linkedItemForCharacterDtos): static
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
