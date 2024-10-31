<?php

declare(strict_types=1);

namespace App\Shared\Services;

use App\Helpers\AssertHelper;
use App\Parameters\Enums\TypeParameterEnum;
use App\Parameters\Models\Parameter;
use App\Parameters\Repositories\ParameterRepositoryInterface;
use App\Shared\Exceptions\Http\InvalidValueForParameterTypeException;

final readonly class ParameterService
{
    public const BOOLEAN_VALUES = ['true', 'false', 'True', 'false', '0', '1'];

    public const BOOLEAN_VALUES_TO_CONVERT_TO_FALSE = ['false', 'False'];

    public const FALSE_VALUE = '0';

    public function __construct(
        private ParameterRepositoryInterface $parameterRepository
    ) {
    }

    public function validateValueTypeByType(TypeParameterEnum $type, string $value): string
    {
        if ($type === TypeParameterEnum::INT && ! is_numeric($value)) {
            throw new InvalidValueForParameterTypeException('Value '.$value.' should be castable to int.');
        }

        if ($type === TypeParameterEnum::BOOLEAN) {
            if (! in_array($value, self::BOOLEAN_VALUES)) {
                throw new InvalidValueForParameterTypeException('Value '.$value.' should be castable to boolean.');
            }
            if (in_array($value, self::BOOLEAN_VALUES_TO_CONVERT_TO_FALSE)) {
                $value = self::FALSE_VALUE;
            }
        }

        return $value;
    }

    public function validateValueTypeByParameter(string $parameterId, string $value): string
    {
        $parameter = $this->getParameterById(parameterId: $parameterId);
        $type = $parameter->type;

        return $this->validateValueTypeByType($type, $value);
    }

    private function getParameterById(string $parameterId): Parameter
    {
        $parameter = $this->parameterRepository->findById(id: $parameterId);

        return AssertHelper::isParameter($parameter);
    }
}
