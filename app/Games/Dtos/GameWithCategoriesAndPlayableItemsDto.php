<?php

declare(strict_types=1);

namespace App\Games\Dtos;

use App\Categories\Collection\CategoryDtoCollection;
use App\PlayableItems\Dtos\PlayableItemDto;
use App\Shared\Dtos\DtoInterface;

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
