<?php

declare(strict_types=1);

namespace App\Categories\Domain\Dtos\CategoryForCharacterDto;

use App\Helpers\UuidHelper;
use App\LinkedItems\Domain\Dtos\LinkedItemForCharacterDto\LinkedItemForCharacterDto;
use App\LinkedItems\Domain\Dtos\LinkedItemForCharacterDto\LinkedItemForCharacterDtoCollection;
use App\Shared\Domain\Dtos\BuilderInterface;
use App\Shared\Infrastructure\Http\Exceptions\NotAValidUuidException;
use App\Shared\Infrastructure\Http\Exceptions\StringIsEmptyException;

final class CategoryForCharacterDtoBuilder implements BuilderInterface
{
    private string $id = '';

    private string $name = '';

    public function __construct(private LinkedItemForCharacterDtoCollection $linkedItemForCharacterDtoCollection = new LinkedItemForCharacterDtoCollection())
    {
    }

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
        $this->linkedItemForCharacterDtoCollection->add($linkedItemsForCharacterDto);

        return $this;
    }

    public function setLinkedItemForCharacterDtoCollection(LinkedItemForCharacterDtoCollection $linkedItemForCharacterDtoCollection): static
    {
        $this->linkedItemForCharacterDtoCollection = $linkedItemForCharacterDtoCollection;

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
            linkedItemForCharacterDtoCollection: $this->linkedItemForCharacterDtoCollection
        );

        $this->id = $this->name = '';
        $this->linkedItemForCharacterDtoCollection = new LinkedItemForCharacterDtoCollection();

        return $categoryForCharacterDto;
    }
}
