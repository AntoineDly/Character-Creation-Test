<?php

declare(strict_types=1);

namespace App\DefaultComponentFields\Handlers;

use App\DefaultComponentFields\Commands\UpdateDefaultComponentFieldCommand;
use App\DefaultComponentFields\Exceptions\DefaultComponentFieldNotFoundException;
use App\DefaultComponentFields\Repositories\DefaultComponentFieldRepositoryInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Exceptions\Http\IncorrectCommandException;
use App\Shared\Handlers\CommandHandlerInterface;
use App\Shared\Services\ParameterService;

final readonly class UpdateDefaultComponentFieldHandler implements CommandHandlerInterface
{
    public function __construct(
        private DefaultComponentFieldRepositoryInterface $defaultComponentFieldRepository,
        private ParameterService $parameterService,
    ) {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof UpdateDefaultComponentFieldCommand) {
            throw new IncorrectCommandException(data: ['handler' => self::class, 'currentCommand' => $command::class, 'expectedCommand' => UpdateDefaultComponentFieldCommand::class]);
        }

        $value = $this->parameterService->validateValueTypeByParameter(parameterId: $command->parameterId, value: $command->value);

        $isUpdated = $this->defaultComponentFieldRepository->updateById(id: $command->id, attributes: ['value' => $value, 'component_id' => $command->componentId, 'parameter_id' => $command->parameterId]);
        if (! $isUpdated) {
            throw new DefaultComponentFieldNotFoundException(data: ['id' => $command->id]);
        }
    }
}
