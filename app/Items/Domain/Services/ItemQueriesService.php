<?php

declare(strict_types=1);

namespace App\Items\Domain\Services;

use App\Helpers\AssertHelper;
use App\Items\Domain\Dtos\ItemDto\ItemDto;
use App\Items\Domain\Dtos\ItemDto\ItemDtoBuilder;
use App\Items\Domain\Models\Item;

final readonly class ItemQueriesService
{
    public function __construct(private ItemDtoBuilder $itemDtoBuilder)
    {
    }

    public function getItemDtoFromModel(?Item $item): ItemDto
    {
        $item = AssertHelper::isItemNotNull($item);

        return $this->itemDtoBuilder
            ->setId(id: $item->id)
            ->build();
    }
}
