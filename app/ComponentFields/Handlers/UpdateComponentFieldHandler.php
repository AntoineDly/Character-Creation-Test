<?php

declare(strict_types=1);

namespace App\ComponentFields\Handlers;

use App\ComponentFields\Commands\UpdateComponentFieldCommand;
use App\ComponentFields\Exceptions\ComponentFieldNotFoundException;
use App\ComponentFields\Repositories\ComponentFieldRepositoryInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Exceptions\Http\IncorrectCommandException;
use App\Shared\Handlers\CommandHandlerInterface;
use App\Shared\Services\ParameterService;

final readonly class UpdateComponentFieldHandler implements CommandHandlerInterface
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
