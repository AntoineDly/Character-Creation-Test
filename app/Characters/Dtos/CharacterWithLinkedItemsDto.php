<?php

declare(strict_types=1);

namespace App\Characters\Dtos;

use App\Categories\Dtos\CategoryForCharacterDto;
use App\Games\Dtos\GameDto;
use App\Shared\Dtos\DtoInterface;

final readonly class CharacterWithLinkedItemsDto implements DtoInterface
{
    /** @param CategoryForCharacterDto[] $categoryForCharacterDtos */
    public function __construct(
        public string $id,
        public GameDto $gameDto,
        public array $categoryForCharacterDtos,
    ) {
    }
}
