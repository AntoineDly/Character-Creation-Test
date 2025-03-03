<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Services;

use App\Helpers\AssertHelper;
use App\LinkedItemFields\Builders\LinkedItemFieldDtoBuilder;
use App\LinkedItemFields\Dtos\LinkedItemFieldDto;
use Illuminate\Database\Eloquent\Model;

final readonly class LinkedItemFieldQueriesService
{
    public function __construct(
        private LinkedItemFieldDtoBuilder $linkedItemFieldDtoBuilder,
    ) {
    }

    public function getLinkedFieldDtoFromModel(?Model $linkedItemField): LinkedItemFieldDto
    {
        $linkedItemField = AssertHelper::isLinkedItemField($linkedItemField);

        return $this->linkedItemFieldDtoBuilder
            ->setId(id: $linkedItemField->id)
            ->setValue(value: $linkedItemField->value)
            ->build();
    }
}
