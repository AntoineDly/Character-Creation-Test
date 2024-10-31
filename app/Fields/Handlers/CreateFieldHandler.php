<?php

declare(strict_types=1);

namespace App\Fields\Handlers;

use App\Fields\Commands\CreateFieldCommand;
use App\Fields\Repositories\FieldRepositoryInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Exceptions\Http\IncorrectCommandException;
use App\Shared\Handlers\CommandHandlerInterface;
use App\Shared\Services\ParameterService;

final readonly class CreateFieldHandler implements CommandHandlerInterface
{
    public function __construct(
        private FieldRepositoryInterface $fieldRepository,
        private ParameterService $parameterService,
    ) {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof CreateFieldCommand) {
            throw new IncorrectCommandException('Command must be an instance of CreateFieldCommand');
        }

        $value = $this->parameterService->validateValueTypeByParameter(parameterId: $command->parameterId, value: $command->value);

        $this->fieldRepository->create(attributes: ['value' => $value, 'linked_item_id' => $command->linkedItemId, 'parameter_id' => $command->parameterId, 'user_id' => $command->userId]);
    }
}
