<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Handlers;

use App\Helpers\AssertHelper;
use App\LinkedItemFields\Commands\UpdatePartiallyLinkedItemFieldCommand;
use App\LinkedItemFields\Exceptions\LinkedItemFieldNotFoundException;
use App\LinkedItemFields\Repositories\LinkedItemFieldRepositoryInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Exceptions\Http\IncorrectCommandException;
use App\Shared\Exceptions\Http\InvalidValueForParameterTypeException;
use App\Shared\Handlers\CommandHandlerInterface;
use App\Shared\Services\ParameterService;

final readonly class UpdatePartiallyLinkedItemFieldHandler implements CommandHandlerInterface
{
    public function __construct(
        private LinkedItemFieldRepositoryInterface $fieldRepository,
        private ParameterService $parameterService,
    ) {
    }

    /**
     * @throws IncorrectCommandException
     * @throws InvalidValueForParameterTypeException
     * @throws LinkedItemFieldNotFoundException
     */
    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof UpdatePartiallyLinkedItemFieldCommand) {
            throw new IncorrectCommandException(data: ['handler' => self::class, 'currentCommand' => $command::class, 'expectedCommand' => UpdatePartiallyLinkedItemFieldCommand::class]);
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
                $field = AssertHelper::isLinkedItemField(
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
            throw new LinkedItemFieldNotFoundException(data: ['id' => $command->id]);
        }
    }
}
