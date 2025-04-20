<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Handlers;

use App\LinkedItemFields\Commands\UpdateLinkedItemFieldCommand;
use App\LinkedItemFields\Exceptions\LinkedItemFieldNotFoundException;
use App\LinkedItemFields\Repositories\LinkedItemFieldRepositoryInterface;
use App\Parameters\Services\ParameterService;
use App\Shared\Commands\CommandInterface;
use App\Shared\Handlers\CommandHandlerInterface;
use App\Shared\Http\Exceptions\IncorrectCommandException;

final readonly class UpdateLinkedItemFieldHandler implements CommandHandlerInterface
{
    public function __construct(
        private LinkedItemFieldRepositoryInterface $fieldRepository,
        private ParameterService $parameterService,
    ) {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof UpdateLinkedItemFieldCommand) {
            throw new IncorrectCommandException(data: ['handler' => self::class, 'currentCommand' => $command::class, 'expectedCommand' => UpdateLinkedItemFieldCommand::class]);
        }

        $value = $this->parameterService->validateValueTypeByParameter(parameterId: $command->parameterId, value: $command->value);

        $isUpdated = $this->fieldRepository->updateById(id: $command->id, attributes: ['value' => $value, 'linked_item_id' => $command->linkedItemId, 'parameter_id' => $command->parameterId]);
        if (! $isUpdated) {
            throw new LinkedItemFieldNotFoundException(data: ['id' => $command->id]);
        }
    }
}
