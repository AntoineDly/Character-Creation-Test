<?php

declare(strict_types=1);

namespace App\Fields\Domain\Services;

use App\Fields\Domain\Dtos\FieldDto\FieldDto;
use App\Fields\Domain\Dtos\FieldDto\FieldDtoBuilder;
use App\Fields\Domain\Dtos\FieldDto\FieldDtoCollection;
use App\Fields\Domain\Interfaces\FieldInterface;
use App\Helpers\AssertHelper;

final readonly class FieldServices
{
    /**
     * @param  array<int, ?FieldInterface>  $fields
     */
    public function getFieldDtoCollectionFromFieldInterfaces(array $fields): FieldDtoCollection
    {
        /** @var FieldDto[] $fieldDtos */
        $fieldDtos = array_map(fn (?FieldInterface $field) => $this->getFieldDtoFromFieldInterface($field), $fields);

        return (new FieldDtoCollection())->setFromFieldDtos($fieldDtos);
    }

    public function getFieldDtoFromFieldInterface(?FieldInterface $field): FieldDto
    {
        $fieldInterface = AssertHelper::isFieldInterfaceNotNull($field);
        $parameter = AssertHelper::isParameterNotNull($fieldInterface->getParameter());

        return FieldDtoBuilder::create()
            ->setId($fieldInterface->getId())
            ->setParameterId($parameter->id)
            ->setName($parameter->name)
            ->setValue($fieldInterface->getValue())
            ->setTypeParameterEnum($parameter->type)
            ->setTypeFieldEnum($fieldInterface->getType())
            ->build();
    }
}
