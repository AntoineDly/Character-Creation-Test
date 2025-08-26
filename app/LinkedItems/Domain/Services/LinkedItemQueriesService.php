<?php

declare(strict_types=1);

namespace App\LinkedItems\Domain\Services;

use App\Helpers\AssertHelper;
use App\LinkedItems\Domain\Dtos\LinkedItemDto\LinkedItemDto;
use App\LinkedItems\Domain\Dtos\LinkedItemDto\LinkedItemDtoBuilder;
use App\LinkedItems\Domain\Models\LinkedItem;

final readonly class LinkedItemQueriesService
{
    public function getLinkedItemDtoFromModel(?LinkedItem $linkedItem): LinkedItemDto
    {
        $linkedItem = AssertHelper::isLinkedItemNotNull($linkedItem);

        return LinkedItemDtoBuilder::create()
            ->setId(id: $linkedItem->id)
            ->build();
    }
}
