<?php

declare(strict_types=1);

namespace App\Games\Domain\Dtos\GameWithCategoriesAndPlayableItemsDto;

use App\Categories\Domain\Dtos\CategoryDto\CategoryDtoCollection;
use App\PlayableItems\Domain\Dtos\PlayableItemDto\PlayableItemDto;
use App\Shared\Domain\Dtos\DtoInterface;

final readonly class GameWithCategoriesAndPlayableItemsDto implements DtoInterface
{
    /**
     * @param  PlayableItemDto[]  $playableItemDtos
     */
    public function __construct(
        public string $id,
        public string $name,
        public CategoryDtoCollection $categoryDtoCollection,
        public array $playableItemDtos
    ) {
    }
}
