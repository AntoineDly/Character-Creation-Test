<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Domain\Services;

use App\Helpers\AssertHelper;
use App\PlayableItemFields\Domain\Builders\PlayableItemFieldDtoBuilder;
use App\PlayableItemFields\Domain\Dtos\PlayableItemFieldDto;
use App\PlayableItemFields\Domain\Models\PlayableItemField;

final readonly class PlayableItemFieldQueriesService
{
    public function __construct(
        private PlayableItemFieldDtoBuilder $playableItemFieldDtoBuilder,
    ) {
    }

    public function getPlayableItemFieldDtoFromModel(?PlayableItemField $playableItemField): PlayableItemFieldDto
    {
        $playableItemField = AssertHelper::isPlayableItemFieldNotNull($playableItemField);

        return $this->playableItemFieldDtoBuilder
            ->setId(id: $playableItemField->id)
            ->setValue(value: $playableItemField->value)
            ->build();
    }
}
