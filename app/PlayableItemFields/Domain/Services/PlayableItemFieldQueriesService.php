<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Domain\Services;

use App\Helpers\AssertHelper;
use App\PlayableItemFields\Domain\Dtos\PlayableItemFieldDto\PlayableItemFieldDto;
use App\PlayableItemFields\Domain\Dtos\PlayableItemFieldDto\PlayableItemFieldDtoBuilder;
use App\PlayableItemFields\Domain\Models\PlayableItemField;

final readonly class PlayableItemFieldQueriesService
{
    public function getPlayableItemFieldDtoFromModel(?PlayableItemField $playableItemField): PlayableItemFieldDto
    {
        $playableItemField = AssertHelper::isPlayableItemFieldNotNull($playableItemField);

        return PlayableItemFieldDtoBuilder::create()
            ->setId(id: $playableItemField->id)
            ->setValue(value: $playableItemField->value)
            ->build();
    }
}
