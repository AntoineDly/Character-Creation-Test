<?php

declare(strict_types=1);

namespace App\ComponentFields\Handlers;

use App\ComponentFields\Commands\CreateComponentFieldCommand;
use App\ComponentFields\Repositories\ComponentFieldRepositoryInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Exceptions\Http\IncorrectCommandException;
use App\Shared\Handlers\CommandHandlerInterface;
use App\Shared\Services\ParameterService;

final readonly class CreateComponentFieldHandler implements CommandHandlerInterface
{
    public function __construct(
        private ComponentFieldRepositoryInterface $componentFieldRepository,
        private ParameterService $parameterService,
    ) {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof CreateComponentFieldCommand) {
            throw new IncorrectCommandException(data: ['handler' => self::class, 'currentCommand' => $command::class, 'expectedCommand' => CreateComponentFieldCommand::class]);
        }

        $value = $this->parameterService->validateValueTypeByParameter(parameterId: $command->parameterId, value: $command->value);

        $this->componentFieldRepository->create(attributes: ['value' => $value, 'component_id' => $command->componentId, 'parameter_id' => $command->parameterId, 'user_id' => $command->userId]);
    }
}
