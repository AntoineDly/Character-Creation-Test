<?php

declare(strict_types=1);

namespace App\Characters\Builders;

use App\Categories\Dtos\CategoryForCharacterDto;
use App\Characters\Dtos\CharacterWithLinkedItemsDto;
use App\Games\Dtos\GameDto;
use App\Games\Exceptions\GameNotFoundException;
use App\Helpers\UuidHelper;
use App\Shared\Builders\BuilderInterface;
use App\Shared\Exceptions\NotAValidUuidException;

final class CharacterWithLinkedItemsDtoBuilder implements BuilderInterface
{
    private string $id = '';

    private ?GameDto $gameDto = null;

    /** @var CategoryForCharacterDto[] */
    private array $categoryForCharacterDtos = [];

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setGameDto(GameDto $gameDto): self
    {
        $this->gameDto = $gameDto;

        return $this;
    }

    public function addCategoryForCharacterDto(CategoryForCharacterDto $linkedItemsForCharacterDto): self
    {
        $this->categoryForCharacterDtos[] = $linkedItemsForCharacterDto;

        return $this;
    }

    /** @param CategoryForCharacterDto[] $categoryForCharacterDto */
    public function setCategoryForCharacterDtos(array $categoryForCharacterDto): self
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
            throw new NotAValidUuidException('id field is not a valid uuid, '.$this->id.' given.', code: 400);
        }

        if (! $this->gameDto instanceof GameDto) {
            throw new GameNotFoundException('Game was not found to create the CharacterWithGameDto', code: 400);
        }

        $characterWithLinkedItemDto = new CharacterWithLinkedItemsDto(
            id: $this->id,
            categoryForCharacterDtos: $this->categoryForCharacterDtos,
            gameDto: $this->gameDto
        );

        $this->id = '';
        $this->categoryForCharacterDtos = [];

        return $characterWithLinkedItemDto;
    }
}
