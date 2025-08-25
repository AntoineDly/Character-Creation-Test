<?php

declare(strict_types=1);

namespace App\Parameters\Domain\Services;

use App\Helpers\AssertHelper;
use App\Parameters\Domain\Enums\TypeParameterEnum;
use App\Parameters\Domain\Models\Parameter;
use App\Parameters\Infrastructure\Repositories\ParameterRepositoryInterface;
use App\Shared\Infrastructure\Http\Exceptions\InvalidValueForParameterTypeException;

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
            throw new InvalidValueForParameterTypeException(data: ['value' => $value, 'valueType' => gettype($value), 'expectedCastableType' => TypeParameterEnum::INT->value]);
        }

        if ($type === TypeParameterEnum::BOOLEAN) {
            if (! in_array($value, self::BOOLEAN_VALUES, true)) {
                throw new InvalidValueForParameterTypeException(data: ['value' => $value, 'valueType' => gettype($value), 'expectedCastableType' => TypeParameterEnum::BOOLEAN->value]);
            }
            if (in_array($value, self::BOOLEAN_VALUES_TO_CONVERT_TO_FALSE, true)) {
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

        return AssertHelper::isParameterNotNull($parameter);
    }
}
