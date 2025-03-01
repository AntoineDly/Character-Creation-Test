<?php

declare(strict_types=1);

namespace App\Games\Dtos;

use App\Categories\Dtos\CategoryDto;
use App\Items\Dtos\ItemDto;
use App\Shared\Dtos\DtoInterface;

final readonly class GameWithCategoriesAndItemsDto implements DtoInterface
{
    /**
     * @param  CategoryDto[]  $categoryDtos
     * @param  ItemDto[]  $itemDtos
     */
    public function __construct(
        public string $id,
        public string $name,
        public array $categoryDtos,
        public array $itemDtos
    ) {
    }
}
