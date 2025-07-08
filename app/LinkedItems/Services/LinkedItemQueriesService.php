<?php

declare(strict_types=1);

namespace App\LinkedItems\Services;

use App\Helpers\AssertHelper;
use App\LinkedItems\Builders\LinkedItemDtoBuilder;
use App\LinkedItems\Dtos\LinkedItemDto;
use App\LinkedItems\Models\LinkedItem;

final readonly class LinkedItemQueriesService
{
    public function __construct(
        private LinkedItemDtoBuilder $linkedItemDtoBuilder,
    ) {
    }

    public function getLinkedItemDtoFromModel(?LinkedItem $linkedItem): LinkedItemDto
    {
        $linkedItem = AssertHelper::isLinkedItemNotNull($linkedItem);

        return $this->linkedItemDtoBuilder
            ->setId(id: $linkedItem->id)
            ->build();
    }
}
