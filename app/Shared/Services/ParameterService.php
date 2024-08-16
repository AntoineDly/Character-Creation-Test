<?php

declare(strict_types=1);

namespace App\Shared\Services;

use App\Parameters\Enums\TypeEnum;
use App\Parameters\Exceptions\ParameterNotFoundException;
use App\Parameters\Models\Parameter;
use App\Parameters\Repositories\ParameterRepositoryInterface;
use App\Shared\Exceptions\InvalidClassException;
use App\Shared\Exceptions\InvalidValueForParameterTypeException;

final readonly class ParameterService
{
    public const BOOLEAN_VALUES = ['true', 'false', 'True', 'false', '0', '1'];

    public const BOOLEAN_VALUES_TO_CONVERT_TO_FALSE = ['false', 'False'];

    public const FALSE_VALUE = '0';

    public function __construct(
        private ParameterRepositoryInterface $parameterRepository
    ) {
    }

    public function validateValueType(string $parameterId, string $value): string
    {
        $parameter = $this->getParameterById(parameterId: $parameterId);

        /** @var array{'type': TypeEnum} $parameterData */
        $parameterData = $parameter->toArray();
        $type = $parameterData['type'];

        if ($type === TypeEnum::INT && ! is_numeric($value)) {
            throw new InvalidValueForParameterTypeException('Value '.$value.' should be castable to int.');
        }

        if ($type === TypeEnum::BOOLEAN) {
            if (! in_array($value, self::BOOLEAN_VALUES)) {
                throw new InvalidValueForParameterTypeException('Value '.$value.' should be castable to boolean.');
            }
            if (in_array($value, self::BOOLEAN_VALUES_TO_CONVERT_TO_FALSE)) {
                $value = self::FALSE_VALUE;
            }
        }

        return $value;
    }

    private function getParameterById(string $parameterId): Parameter
    {
        $parameter = $this->parameterRepository->findById(id: $parameterId);

        if (is_null($parameter)) {
            throw new ParameterNotFoundException(message: 'Component not found', code: 404);
        }

        if (! $parameter instanceof Parameter) {
            throw new InvalidClassException(
                'Class was expected to be Parameter, '.get_class($parameter).' given.'
            );
        }

        return $parameter;
    }
}
