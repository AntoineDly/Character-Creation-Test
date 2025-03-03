<?php

declare(strict_types=1);

namespace App\Games\Dtos;

use App\Categories\Dtos\CategoryDto;
use App\PlayableItems\Dtos\PlayableItemDto;
use App\Shared\Dtos\DtoInterface;

final readonly class GameWithCategoriesAndPlayableItemsDto implements DtoInterface
{
    /**
     * @param  CategoryDto[]  $categoryDtos
     * @param  PlayableItemDto[]  $playableItemDtos
     */
    public function __construct(
        public string $id,
        public string $name,
        public array $categoryDtos,
        public array $playableItemDtos
    ) {
    }
}
