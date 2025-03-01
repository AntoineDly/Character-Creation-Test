<?php

declare(strict_types=1);

namespace App\Items\Services;

use App\Helpers\AssertHelper;
use App\Items\Builders\ItemDtoBuilder;
use App\Items\Dtos\ItemDto;
use Illuminate\Database\Eloquent\Model;

final readonly class ItemQueriesService
{
    public function __construct(private ItemDtoBuilder $itemDtoBuilder)
    {
    }

    public function getItemDtoFromModel(?Model $item): ItemDto
    {
        $item = AssertHelper::isItem($item);

        return $this->itemDtoBuilder
            ->setId(id: $item->id)
            ->build();
    }
}
