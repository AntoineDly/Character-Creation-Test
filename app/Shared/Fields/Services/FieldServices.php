<?php

declare(strict_types=1);

namespace App\Shared\Fields\Services;

use App\Helpers\AssertHelper;
use App\LinkedItems\Builders\LinkedItemForCharacterDtoBuilder;
use App\Shared\Enums\TypeFieldEnum;
use App\Shared\Fields\Builders\FieldDtoBuilder;
use Illuminate\Database\Eloquent\Model;

final readonly class FieldServices
{
    public function __construct(private FieldDtoBuilder $fieldDtoBuilder)
    {
    }

    public function insertFieldIntoLinkedItemsForCharacterDtoBuilder(
        LinkedItemForCharacterDtoBuilder $linkedItemsForCharacterDtoBuilder,
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

        $fieldDto = $this->fieldDtoBuilder
            ->setId($fieldInterface->getId())
            ->setParameterId($parameter->id)
            ->setName($parameterName)
            ->setValue($fieldInterface->getValue())
            ->setTypeParameterEnum($parameter->type)
            ->setTypeFieldEnum($type)
            ->build();

        $linkedItemsForCharacterDtoBuilder
            ->addSharedFieldDto($fieldDto);
    }
}
