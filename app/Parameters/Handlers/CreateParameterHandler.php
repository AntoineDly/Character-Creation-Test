<?php

declare(strict_types=1);

namespace App\Parameters\Handlers;

use App\Parameters\Commands\CreateParameterCommand;
use App\Parameters\Repositories\ParameterRepositoryInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Exceptions\IncorrectCommandException;
use App\Shared\Handlers\CommandHandlerInterface;

final readonly class CreateParameterHandler implements CommandHandlerInterface
{
    public function __construct(private ParameterRepositoryInterface $parameterRepository)
    {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof CreateParameterCommand) {
            throw new IncorrectCommandException('Command must be an instance of CreateParameterCommand');
        }

        $this->parameterRepository->create(attributes: ['name' => $command->name, 'type' => $command->type, 'user_id' => $command->userId]);
    }
}
