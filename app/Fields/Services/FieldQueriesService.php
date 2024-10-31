<?php

declare(strict_types=1);

namespace App\Fields\Services;

use App\Fields\Builders\FieldDtoBuilder;
use App\Fields\Dtos\FieldDto;
use App\Helpers\AssertHelper;
use App\LinkedItems\Builders\LinkedItemsForCharacterDtoBuilder;
use App\Shared\Builders\SharedFieldDtoBuilder\SharedFieldDtoBuilder;
use App\Shared\Enums\TypeFieldEnum;
use Illuminate\Database\Eloquent\Model;

final readonly class FieldQueriesService
{
    public function __construct(
        private SharedFieldDtoBuilder $sharedFieldDtoBuilder,
        private FieldDtoBuilder $fieldDtoBuilder,
    ) {
    }

    public function getSharedFieldDtoFromFieldInterface(
        LinkedItemsForCharacterDtoBuilder $linkedItemsForCharacterDtoBuilder,
        Model $fieldInterface,
        TypeFieldEnum $type
    ): void {
        $fieldInterface = AssertHelper::isFieldInterface($fieldInterface);
        $parameter = AssertHelper::isParameter($fieldInterface->getParameter());
        $parameterName = $parameter->name;
        if ($linkedItemsForCharacterDtoBuilder->containsSharedFieldDtoWithSameNameAndBiggerWeightOrRemoveIfLower(
            $parameterName,
            $type
        )) {
            return;
        }

        $sharedFieldDto = $this->sharedFieldDtoBuilder
            ->setId($fieldInterface->getId())
            ->setParameterId($parameter->id)
            ->setName($parameterName)
            ->setValue($fieldInterface->getValue())
            ->setTypeParameterEnum($parameter->type)
            ->setTypeFieldEnum($type)
            ->build();

        $linkedItemsForCharacterDtoBuilder
            ->addSharedFieldDto($sharedFieldDto);
    }

    public function getFieldDtoFromModel(?Model $field): FieldDto
    {
        $field = AssertHelper::isField($field);

        return $this->fieldDtoBuilder
            ->setId(id: $field->id)
            ->setValue(value: $field->value)
            ->build();
    }
}
