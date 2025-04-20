<?php

declare(strict_types=1);

namespace App\Shared\Fields\Services;

use App\Helpers\AssertHelper;
use App\Shared\Fields\Builders\FieldDtoBuilder;
use App\Shared\Fields\Collection\FieldDtoCollection;
use App\Shared\Fields\Dtos\FieldDto;
use Illuminate\Database\Eloquent\Model;

final readonly class FieldServices
{
    public function __construct(private FieldDtoBuilder $fieldDtoBuilder)
    {
    }

    /**
     * @param  array<int, ?Model>  $fields
     */
    public function getFieldDtoCollectionFromFieldInterfaces(array $fields): FieldDtoCollection
    {
        /** @var FieldDto[] $fieldDtos */
        $fieldDtos = [];

        foreach ($fields as $field) {
            $fieldInterface = AssertHelper::isFieldInterface($field);
            $parameter = AssertHelper::isParameter($fieldInterface->getParameter());
            $parameterName = $parameter->name;

            $fieldDtos[] = $this->fieldDtoBuilder
                ->setId($fieldInterface->getId())
                ->setParameterId($parameter->id)
                ->setName($parameterName)
                ->setValue($fieldInterface->getValue())
                ->setTypeParameterEnum($parameter->type)
                ->setTypeFieldEnum($fieldInterface->getType())
                ->build();
        }

        return (new FieldDtoCollection())->setFromFieldDtos($fieldDtos);
    }
}
