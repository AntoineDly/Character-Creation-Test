<?php

declare(strict_types=1);

namespace App\Fields\Handlers;

use App\Fields\Commands\UpdatePartiallyFieldCommand;
use App\Fields\Exceptions\FieldNotFoundException;
use App\Fields\Repositories\FieldRepositoryInterface;
use App\Helpers\AssertHelper;
use App\Shared\Commands\CommandInterface;
use App\Shared\Exceptions\Http\IncorrectCommandException;
use App\Shared\Exceptions\Http\InvalidValueForParameterTypeException;
use App\Shared\Handlers\CommandHandlerInterface;
use App\Shared\Services\ParameterService;

final readonly class UpdatePartiallyFieldHandler implements CommandHandlerInterface
{
    public function __construct(
        private FieldRepositoryInterface $fieldRepository,
        private ParameterService $parameterService,
    ) {
    }

    /**
     * @throws IncorrectCommandException
     * @throws InvalidValueForParameterTypeException
     * @throws FieldNotFoundException
     */
    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof UpdatePartiallyFieldCommand) {
            throw new IncorrectCommandException('Command must be an instance of UpdatePartiallyFieldCommand');
        }

        /** @var array{'value': ?string, 'linkedItemId': ?string, 'parameterId': ?string} $attributes */
        $attributes = [];

        $value = $command->value;
        $parameterId = $command->parameterId;
        $linkedItemId = $command->linkedItemId;

        if (! is_null($value) && ! is_null($parameterId)) {
            $attributes['value'] = $this->parameterService->validateValueTypeByParameter(
                parameterId: $parameterId,
                value: $value
            );
            $attributes['parameter_id'] = $parameterId;
        } else {
            if (! is_null($value)) {
                $field = AssertHelper::isField(
                    $this->fieldRepository->findById(id: $command->id)
                );
                $parameter = AssertHelper::isParameter($field->getParameter());
                $attributes['value'] = $this->parameterService->validateValueTypeByType(
                    type: $parameter->type,
                    value: $value
                );
            }

            if (! is_null($parameterId)) {
                $attributes['parameter_id'] = $parameterId;
            }
        }

        if (! is_null($linkedItemId)) {
            $attributes['linked_item_id'] = $linkedItemId;
        }

        $isUpdated = $this->fieldRepository->updateById(id: $command->id, attributes: $attributes);
        if (! $isUpdated) {
            throw new FieldNotFoundException(message: 'Field not found with id : '.$command->id);
        }
    }
}
