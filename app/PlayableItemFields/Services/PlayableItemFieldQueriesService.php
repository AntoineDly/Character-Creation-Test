<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Services;

use App\Helpers\AssertHelper;
use App\PlayableItemFields\Builders\PlayableItemFieldDtoBuilder;
use App\PlayableItemFields\Dtos\PlayableItemFieldDto;
use Illuminate\Database\Eloquent\Model;

final readonly class PlayableItemFieldQueriesService
{
    public function __construct(
        private PlayableItemFieldDtoBuilder $playableItemFieldDtoBuilder,
    ) {
    }

    public function getPlayableItemFieldDtoFromModel(?Model $playableItemField): PlayableItemFieldDto
    {
        $playableItemField = AssertHelper::isPlayableItemField($playableItemField);

        return $this->playableItemFieldDtoBuilder
            ->setId(id: $playableItemField->id)
            ->setValue(value: $playableItemField->value)
            ->build();
    }
}
