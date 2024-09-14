<?php

declare(strict_types=1);

namespace App\LinkedItems\Builders;

use App\Helpers\UuidHelper;
use App\LinkedItems\Dtos\LinkedItemsForCharacterDto;
use App\Shared\Builders\BuilderInterface;
use App\Shared\Dtos\SharedFieldDto\SharedFieldDto;
use App\Shared\Exceptions\NotAValidUuidException;
use App\Shared\Exceptions\StringIsEmptyException;

final class LinkedItemsForCharacterDtoBuilder implements BuilderInterface
{
    private string $id = '';

    private string $name = '';

    /** @var SharedFieldDto[] */
    private array $sharedFieldDtos = [];

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

    public function addSharedFieldDto(SharedFieldDto $sharedFieldDto): self
    {
        $this->sharedFieldDtos[] = $sharedFieldDto;

        return $this;
    }

    /** @param SharedFieldDto[] $sharedFieldDtos */
    public function setSharedFieldDtos(array $sharedFieldDtos): self
    {
        $this->sharedFieldDtos = $sharedFieldDtos;

        return $this;
    }

    public function build(): LinkedItemsForCharacterDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException('id field is not a valid uuid, '.$this->id.' given.', code: 400);
        }

        if ($this->name === '') {
            throw new StringIsEmptyException('name field is empty', code: 400);
        }

        $linkedItemsForCharacterDto = new LinkedItemsForCharacterDto(
            id: $this->id,
            name: $this->name,
            sharedFieldDtos: $this->sharedFieldDtos
        );

        $this->id = $this->name = '';
        $this->sharedFieldDtos = [];

        return $linkedItemsForCharacterDto;
    }
}
