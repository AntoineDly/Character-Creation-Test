<?php

declare(strict_types=1);

namespace App\DefaultFields\Handlers;

use App\DefaultFields\Commands\CreateDefaultFieldCommand;
use App\DefaultFields\Repositories\DefaultFieldRepositoryInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Exceptions\IncorrectCommandException;
use App\Shared\Handlers\CommandHandlerInterface;
use App\Shared\Services\ParameterService;

final readonly class CreateDefaultFieldHandler implements CommandHandlerInterface
{
    public function __construct(
        private DefaultFieldRepositoryInterface $defaultFieldRepository,
        private ParameterService $parameterService,
    ) {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof CreateDefaultFieldCommand) {
            throw new IncorrectCommandException('Command must be an instance of CreateDefaultFieldCommand');
        }

        $value = $this->parameterService->validateValueType(parameterId: $command->parameterId, value: $command->value);

        $this->defaultFieldRepository->create(attributes: ['value' => $value, 'item_id' => $command->itemId, 'parameter_id' => $command->parameterId, 'user_id' => $command->userId]);
    }
}
