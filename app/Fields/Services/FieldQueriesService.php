<?php

declare(strict_types=1);

namespace App\Fields\Services;

use App\Helpers\AssertHelper;
use App\LinkedItems\Builders\LinkedItemsForCharacterDtoBuilder;
use App\Shared\Builders\SharedFieldDtoBuilder\SharedFieldDtoBuilder;
use App\Shared\Enums\TypeFieldEnum;
use Illuminate\Database\Eloquent\Model;

final readonly class FieldQueriesService
{
    public function __construct(
        private SharedFieldDtoBuilder $sharedFieldDtoBuilder
    ) {
    }

    public function getSharedFieldDtoFromFieldInterface(
        LinkedItemsForCharacterDtoBuilder $linkedItemsForCharacterDtoBuilder,
        Model $field,
        TypeFieldEnum $type
    ): void {
        $field = AssertHelper::isField($field);
        $parameter = AssertHelper::isParameter($field->getParameter());
        $parameterName = $parameter->name;
        if ($linkedItemsForCharacterDtoBuilder->containsSharedFieldDtoWithSameNameAndBiggerWeightOrRemoveIfLower(
            $parameterName,
            $type
        )) {
            return;
        }

        $sharedFieldDto = $this->sharedFieldDtoBuilder
            ->setId($field->getId())
            ->setParameterId($parameter->id)
            ->setName($parameterName)
            ->setValue($field->getValue())
            ->setTypeParameterEnum($parameter->type)
            ->setTypeFieldEnum($type)
            ->build();

        $linkedItemsForCharacterDtoBuilder
            ->addSharedFieldDto($sharedFieldDto);
    }
}
