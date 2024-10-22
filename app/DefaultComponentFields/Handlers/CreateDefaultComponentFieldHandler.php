<?php

declare(strict_types=1);

namespace App\DefaultComponentFields\Handlers;

use App\DefaultComponentFields\Commands\CreateDefaultComponentFieldCommand;
use App\DefaultComponentFields\Repositories\DefaultComponentFieldRepositoryInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Exceptions\Http\IncorrectCommandException;
use App\Shared\Handlers\CommandHandlerInterface;
use App\Shared\Services\ParameterService;

final readonly class CreateDefaultComponentFieldHandler implements CommandHandlerInterface
{
    public function __construct(
        private DefaultComponentFieldRepositoryInterface $defaultComponentFieldRepository,
        private ParameterService $parameterService,
    ) {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof CreateDefaultComponentFieldCommand) {
            throw new IncorrectCommandException('Command must be an instance of CreateDefaultComponentFieldCommand');
        }

        $value = $this->parameterService->validateValueType(parameterId: $command->parameterId, value: $command->value);

        $this->defaultComponentFieldRepository->create(attributes: ['value' => $value, 'component_id' => $command->componentId, 'parameter_id' => $command->parameterId, 'user_id' => $command->userId]);
    }
}
