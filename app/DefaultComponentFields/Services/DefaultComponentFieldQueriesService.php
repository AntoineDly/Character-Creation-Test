<?php

declare(strict_types=1);

namespace App\DefaultComponentFields\Services;

use App\DefaultComponentFields\Builders\DefaultComponentFieldDtoBuilder;
use App\DefaultComponentFields\Dtos\DefaultComponentFieldDto;
use App\Helpers\AssertHelper;
use Illuminate\Database\Eloquent\Model;

final readonly class DefaultComponentFieldQueriesService
{
    public function __construct(
        private DefaultComponentFieldDtoBuilder $defaultComponentFieldDtoBuilder,
    ) {
    }

    public function getDefaultComponentFieldDtoFromModel(?Model $defaultComponentField): DefaultComponentFieldDto
    {
        $defaultComponentField = AssertHelper::isDefaultComponentField($defaultComponentField);

        return $this->defaultComponentFieldDtoBuilder
            ->setId(id: $defaultComponentField->id)
            ->setValue(value: $defaultComponentField->value)
            ->build();
    }
}
