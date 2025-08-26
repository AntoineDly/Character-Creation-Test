<?php

declare(strict_types=1);

namespace App\Fields\Services;

use App\Fields\Dtos\FieldDto\FieldDto;
use App\Fields\Dtos\FieldDto\FieldDtoBuilder;
use App\Fields\Dtos\FieldDto\FieldDtoCollection;
use App\Fields\Interfaces\FieldInterface;
use App\Helpers\AssertHelper;

final readonly class FieldServices
{
    public function __construct(private FieldDtoBuilder $fieldDtoBuilder)
    {
    }

    /**
     * @param  array<int, ?FieldInterface>  $fields
     */
    public function getFieldDtoCollectionFromFieldInterfaces(array $fields): FieldDtoCollection
    {
        /** @var FieldDto[] $fieldDtos */
        $fieldDtos = [];

        foreach ($fields as $field) {
            $fieldInterface = AssertHelper::isFieldInterfaceNotNull($field);
            $parameter = AssertHelper::isParameterNotNull($fieldInterface->getParameter());

            $fieldDtos[] = $this->fieldDtoBuilder
                ->setId($fieldInterface->getId())
                ->setParameterId($parameter->id)
                ->setName($parameter->name)
                ->setValue($fieldInterface->getValue())
                ->setTypeParameterEnum($parameter->type)
                ->setTypeFieldEnum($fieldInterface->getType())
                ->build();
        }

        return (new FieldDtoCollection())->setFromFieldDtos($fieldDtos);
    }
}
