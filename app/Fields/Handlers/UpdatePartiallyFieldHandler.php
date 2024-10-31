<?php

declare(strict_types=1);

namespace App\Fields\Handlers;

use App\Fields\Commands\UpdatePartiallyFieldCommand;
use App\Fields\Exceptions\FieldNotFoundException;
use App\Fields\Repositories\FieldRepositoryInterface;
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

        if (! is_null($command->value) && ! is_null($command->parameterId)) {
            $value = $this->parameterService->validateValueTypeByParameter(parameterId: $command->parameterId, value: $command->value);

            $attributes['value'] = $value;
        }

        if (! is_null($command->linkedItemId)) {
            $attributes['linked_item_id'] = $command->linkedItemId;
        }

        if (! is_null($command->parameterId)) {
            $attributes['parameter_id'] = $command->parameterId;
        }

        $isUpdated = $this->fieldRepository->updateById(id: $command->id, attributes: $attributes);
        if (! $isUpdated) {
            throw new FieldNotFoundException(message: 'Field not found with id : '.$command->id);
        }
    }
}
