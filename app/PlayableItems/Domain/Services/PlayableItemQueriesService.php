<?php

declare(strict_types=1);

namespace App\PlayableItems\Domain\Services;

use App\Helpers\AssertHelper;
use App\PlayableItems\Domain\Dtos\PlayableItemDto\PlayableItemDto;
use App\PlayableItems\Domain\Dtos\PlayableItemDto\PlayableItemDtoBuilder;
use App\PlayableItems\Domain\Models\PlayableItem;

final readonly class PlayableItemQueriesService
{
    public function getPlayableItemDtoFromModel(?PlayableItem $playableItem): PlayableItemDto
    {
        $playableItem = AssertHelper::isPlayableItemNotNull($playableItem);

        return PlayableItemDtoBuilder::create()
            ->setId(id: $playableItem->id)
            ->build();
    }
}
