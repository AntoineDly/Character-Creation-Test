<?php

declare(strict_types=1);

namespace App\ComponentFields\Application\Commands\UpdateComponentFieldCommand;

use App\ComponentFields\Infrastructure\Exceptions\ComponentFieldNotFoundException;
use App\ComponentFields\Infrastructure\Repositories\ComponentFieldRepositoryInterface;
use App\Parameters\Domain\Services\ParameterService;
use App\Shared\Commands\CommandHandlerInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Http\Exceptions\IncorrectCommandException;

final readonly class UpdateComponentFieldCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ComponentFieldRepositoryInterface $componentFieldRepository,
        private ParameterService $parameterService,
    ) {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof UpdateComponentFieldCommand) {
            throw new IncorrectCommandException(data: ['handler' => self::class, 'currentCommand' => $command::class, 'expectedCommand' => UpdateComponentFieldCommand::class]);
        }

        $value = $this->parameterService->validateValueTypeByParameter(parameterId: $command->parameterId, value: $command->value);

        $isUpdated = $this->componentFieldRepository->updateById(id: $command->id, attributes: ['value' => $value, 'component_id' => $command->componentId, 'parameter_id' => $command->parameterId]);
        if (! $isUpdated) {
            throw new ComponentFieldNotFoundException(data: ['id' => $command->id]);
        }
    }
}
