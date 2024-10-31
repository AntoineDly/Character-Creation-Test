<?php

declare(strict_types=1);

namespace App\Fields\Handlers;

use App\Fields\Commands\UpdateFieldCommand;
use App\Fields\Exceptions\FieldNotFoundException;
use App\Fields\Repositories\FieldRepositoryInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Exceptions\Http\IncorrectCommandException;
use App\Shared\Handlers\CommandHandlerInterface;
use App\Shared\Services\ParameterService;

final readonly class UpdateFieldHandler implements CommandHandlerInterface
{
    public function __construct(
        private FieldRepositoryInterface $fieldRepository,
        private ParameterService $parameterService,
    ) {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof UpdateFieldCommand) {
            throw new IncorrectCommandException('Command must be an instance of UpdateFieldCommand');
        }

        $value = $this->parameterService->validateValueTypeByParameter(parameterId: $command->parameterId, value: $command->value);

        $isUpdated = $this->fieldRepository->updateById(id: $command->id, attributes: ['value' => $value, 'linked_item_id' => $command->linkedItemId, 'parameter_id' => $command->parameterId]);
        if (! $isUpdated) {
            throw new FieldNotFoundException(message: 'Field not found with id : '.$command->id);
        }
    }
}
