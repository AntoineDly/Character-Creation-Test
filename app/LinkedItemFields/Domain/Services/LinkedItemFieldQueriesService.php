<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Domain\Services;

use App\Helpers\AssertHelper;
use App\LinkedItemFields\Domain\Dtos\LinkedItemFieldDto\LinkedItemFieldDto;
use App\LinkedItemFields\Domain\Dtos\LinkedItemFieldDto\LinkedItemFieldDtoBuilder;
use App\LinkedItemFields\Domain\Models\LinkedItemField;

final readonly class LinkedItemFieldQueriesService
{
    public function getLinkedFieldDtoFromModel(?LinkedItemField $linkedItemField): LinkedItemFieldDto
    {
        $linkedItemField = AssertHelper::isLinkedItemFieldNotNull($linkedItemField);

        return LinkedItemFieldDtoBuilder::create()
            ->setId(id: $linkedItemField->id)
            ->setValue(value: $linkedItemField->value)
            ->build();
    }
}
