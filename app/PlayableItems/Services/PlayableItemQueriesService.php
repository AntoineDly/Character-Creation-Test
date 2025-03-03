<?php

declare(strict_types=1);

namespace App\PlayableItems\Services;

use App\Helpers\AssertHelper;
use App\PlayableItems\Builders\PlayableItemDtoBuilder;
use App\PlayableItems\Dtos\PlayableItemDto;
use Illuminate\Database\Eloquent\Model;

final readonly class PlayableItemQueriesService
{
    public function __construct(
        private PlayableItemDtoBuilder $playableItemDtoBuilder,
    ) {
    }

    public function getPlayableItemDtoFromModel(?Model $playableItem): PlayableItemDto
    {
        $playableItem = AssertHelper::isPlayableItem($playableItem);

        return $this->playableItemDtoBuilder
            ->setId(id: $playableItem->id)
            ->build();
    }
}
