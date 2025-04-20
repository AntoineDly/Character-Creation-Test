<?php

declare(strict_types=1);

namespace App\Games\Builders;

use App\Categories\Dtos\CategoryDto;
use App\Games\Dtos\GameWithCategoriesAndPlayableItemsDto;
use App\Helpers\UuidHelper;
use App\PlayableItems\Dtos\PlayableItemDto;
use App\Shared\Builders\BuilderInterface;
use App\Shared\Http\Exceptions\NotAValidUuidException;
use App\Shared\Http\Exceptions\StringIsEmptyException;

final class GameWithCategoriesAndPlayableItemsDtoBuilder implements BuilderInterface
{
    private string $id = '';

    private string $name = '';

    /** @var CategoryDto[] */
    private array $categoryDtos = [];

    /** @var PlayableItemDto[] */
    private array $playableItemDtos = [];

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

    /** @param CategoryDto[] $categoryDtos */
    public function setCategoryDtos(array $categoryDtos): static
    {
        $this->categoryDtos = $categoryDtos;

        return $this;
    }

    /** @param PlayableItemDto[] $playableItemDtos */
    public function setPlayableItemDtos(array $playableItemDtos): static
    {
        $this->playableItemDtos = $playableItemDtos;

        return $this;
    }

    public function build(): GameWithCategoriesAndPlayableItemsDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException(data: ['value' => $this->id]);
        }

        if ($this->name === '') {
            throw new StringIsEmptyException(data: ['field' => 'name']);
        }

        $GameWithCategoriesAndPlayableItemsDto = new GameWithCategoriesAndPlayableItemsDto(
            id: $this->id,
            name: $this->name,
            categoryDtos: $this->categoryDtos,
            playableItemDtos: $this->playableItemDtos
        );

        $this->id = $this->name = '';
        $this->categoryDtos = $this->playableItemDtos = [];

        return $GameWithCategoriesAndPlayableItemsDto;
    }
}
