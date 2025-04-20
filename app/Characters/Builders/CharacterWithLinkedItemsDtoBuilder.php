<?php

declare(strict_types=1);

namespace App\Characters\Builders;

use App\Categories\Dtos\CategoryForCharacterDto;
use App\Characters\Dtos\CharacterWithLinkedItemsDto;
use App\Games\Dtos\GameDto;
use App\Games\Exceptions\GameNotFoundException;
use App\Helpers\UuidHelper;
use App\Shared\Builders\BuilderInterface;
use App\Shared\Exceptions\Http\NotAValidUuidException;

final class CharacterWithLinkedItemsDtoBuilder implements BuilderInterface
{
    private string $id = '';

    private ?GameDto $gameDto = null;

    /** @var CategoryForCharacterDto[] */
    private array $categoryForCharacterDtos = [];

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function setGameDto(GameDto $gameDto): static
    {
        $this->gameDto = $gameDto;

        return $this;
    }

    public function addCategoryForCharacterDto(CategoryForCharacterDto $linkedItemsForCharacterDto): static
    {
        $this->categoryForCharacterDtos[] = $linkedItemsForCharacterDto;

        return $this;
    }

    /** @param CategoryForCharacterDto[] $categoryForCharacterDto */
    public function setCategoryForCharacterDtos(array $categoryForCharacterDto): static
    {
        $this->categoryForCharacterDtos = $categoryForCharacterDto;

        return $this;
    }

    /**
     * @throws NotAValidUuidException
     */
    public function build(): CharacterWithLinkedItemsDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException(data: ['value' => $this->id]);
        }

        if (! $this->gameDto instanceof GameDto) {
            throw new GameNotFoundException('Game was not found to create the CharacterWithGameDto');
        }

        $characterWithLinkedItemDto = new CharacterWithLinkedItemsDto(
            id: $this->id,
            gameDto: $this->gameDto,
            categoryForCharacterDtos: $this->categoryForCharacterDtos
        );

        $this->id = '';
        $this->categoryForCharacterDtos = [];

        return $characterWithLinkedItemDto;
    }
}
