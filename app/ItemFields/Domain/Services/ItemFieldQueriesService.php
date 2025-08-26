<?php

declare(strict_types=1);

namespace App\ItemFields\Domain\Services;

use App\Helpers\AssertHelper;
use App\ItemFields\Domain\Dtos\ItemFieldDto\ItemFieldDto;
use App\ItemFields\Domain\Dtos\ItemFieldDto\ItemFieldDtoBuilder;
use App\ItemFields\Domain\Models\ItemField;

final readonly class ItemFieldQueriesService
{
    public function getItemFieldDtoFromModel(?ItemField $itemField): ItemFieldDto
    {
        $itemField = AssertHelper::isItemFieldNotNull($itemField);

        return ItemFieldDtoBuilder::create()
            ->setId(id: $itemField->id)
            ->setValue(value: $itemField->value)
            ->build();
    }
}
