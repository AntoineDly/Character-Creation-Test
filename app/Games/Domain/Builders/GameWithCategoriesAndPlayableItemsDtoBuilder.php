<?php

declare(strict_types=1);

namespace App\Games\Domain\Builders;

use App\Categories\Domain\Collection\CategoryDtoCollection;
use App\Games\Domain\Dtos\GameWithCategoriesAndPlayableItemsDto;
use App\Helpers\UuidHelper;
use App\PlayableItems\Domain\Dtos\PlayableItemDto;
use App\Shared\Builders\BuilderInterface;
use App\Shared\Http\Exceptions\NotAValidUuidException;
use App\Shared\Http\Exceptions\StringIsEmptyException;

final class GameWithCategoriesAndPlayableItemsDtoBuilder implements BuilderInterface
{
    private string $id = '';

    private string $name = '';

    private CategoryDtoCollection $categoryDtoCollection;

    /** @var PlayableItemDto[] */
    private array $playableItemDtos = [];

    public function __construct()
    {
        $this->categoryDtoCollection = CategoryDtoCollection::createEmpty();
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

    public function setCategoryDtoCollection(CategoryDtoCollection $categoryDtoCollection): static
    {
        $this->categoryDtoCollection = $categoryDtoCollection;

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
            categoryDtoCollection: $this->categoryDtoCollection,
            playableItemDtos: $this->playableItemDtos
        );

        $this->id = $this->name = '';
        $this->categoryDtoCollection = CategoryDtoCollection::createEmpty();
        $this->playableItemDtos = [];

        return $GameWithCategoriesAndPlayableItemsDto;
    }
}
