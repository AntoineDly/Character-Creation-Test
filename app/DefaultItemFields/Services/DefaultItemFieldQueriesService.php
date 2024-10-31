<?php

declare(strict_types=1);

namespace App\DefaultItemFields\Services;

use App\DefaultItemFields\Builders\DefaultItemFieldDtoBuilder;
use App\DefaultItemFields\Dtos\DefaultItemFieldDto;
use App\Helpers\AssertHelper;
use Illuminate\Database\Eloquent\Model;

final readonly class DefaultItemFieldQueriesService
{
    public function __construct(
        private DefaultItemFieldDtoBuilder $defaultItemFieldDtoBuilder,
    ) {
    }

    public function getDefaultItemFieldDtoFromModel(?Model $defaultItemField): DefaultItemFieldDto
    {
        $defaultItemField = AssertHelper::isDefaultItemField($defaultItemField);

        return $this->defaultItemFieldDtoBuilder
            ->setId(id: $defaultItemField->id)
            ->setValue(value: $defaultItemField->value)
            ->build();
    }
}
