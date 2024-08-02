<?php

declare(strict_types=1);

namespace App\DefaultFields\Handlers;

use App\Base\Commands\CommandInterface;
use App\Base\Exceptions\IncorrectCommandException;
use App\Base\Exceptions\InvalidClassException;
use App\Base\Exceptions\InvalidValueForParameterTypeException;
use App\Base\Handlers\CommandHandlerInterface;
use App\DefaultFields\Commands\CreateDefaultFieldCommand;
use App\DefaultFields\Repositories\DefaultFieldRepositoryInterface;
use App\Parameters\Enums\TypeEnum;
use App\Parameters\Exceptions\ParameterNotFoundException;
use App\Parameters\Models\Parameter;
use App\Parameters\Repositories\ParameterRepositoryInterface;

final readonly class CreateDefaultFieldHandler implements CommandHandlerInterface
{
    public const BOOLEAN_VALUES = ['true', 'false', 'True', 'false', '0', '1'];

    public const BOOLEAN_VALUES_TO_CONVERT_TO_FALSE = ['false', 'False'];

    public const FALSE_VALUE = '0';

    public function __construct(
        private DefaultFieldRepositoryInterface $defaultFieldRepository,
        private ParameterRepositoryInterface $parameterRepository,
    ) {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof CreateDefaultFieldCommand) {
            throw new IncorrectCommandException('Command must be an instance of CreateDefaultFieldCommand');
        }

        $parameter = $this->parameterRepository->findById(id: $command->parameterId);

        if (is_null($parameter)) {
            throw new ParameterNotFoundException(message: 'Item not found', code: 404);
        }

        if (! $parameter instanceof Parameter) {
            throw new InvalidClassException(
                'Class was expected to be Parameter, '.get_class($parameter).' given.'
            );
        }

        $value = $command->value;

        /** @var array{'type': TypeEnum} $parameterData */
        $parameterData = $parameter->toArray();
        $type = $parameterData['type'];

        if ($type === TypeEnum::INT && ! is_numeric($value)) {
            throw new InvalidValueForParameterTypeException('Value '.$value.'should be castable to int.');
        }

        if ($type === TypeEnum::BOOLEAN) {
            if (! in_array($value, self::BOOLEAN_VALUES)) {
                throw new InvalidValueForParameterTypeException('Value '.$value.'should be castable to boolean.');
            }
            if (in_array($value, self::BOOLEAN_VALUES_TO_CONVERT_TO_FALSE)) {
                $value = self::FALSE_VALUE;
            }
        }

        $this->defaultFieldRepository->create(attributes: ['value' => $value, 'item_id' => $command->itemId, 'parameter_id' => $command->parameterId, 'user_id' => $command->userId]);
    }
}
