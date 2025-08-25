<?php

declare(strict_types=1);

namespace App\ComponentFields\Application\Commands\CreateComponentFieldCommand;

use App\ComponentFields\Infrastructure\Repositories\ComponentFieldRepositoryInterface;
use App\Parameters\Domain\Services\ParameterService;
use App\Shared\Application\Commands\CommandHandlerInterface;
use App\Shared\Application\Commands\CommandInterface;
use App\Shared\Application\Commands\IncorrectCommandException;

final readonly class CreateComponentFieldCommandHandler implements CommandHandlerInterface
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
