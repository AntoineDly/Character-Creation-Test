<?php

declare(strict_types=1);

namespace App\Items\Services;

use App\Helpers\AssertHelper;
use App\Items\Builders\ItemDtoBuilder;
use App\Items\Dtos\ItemDto;
use App\Items\Models\Item;

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
