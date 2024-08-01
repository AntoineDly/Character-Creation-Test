<?php

declare(strict_types=1);

namespace App\Parameters\Handlers;

use App\Base\Commands\CommandInterface;
use App\Base\Exceptions\IncorrectCommandException;
use App\Base\Handlers\CommandHandlerInterface;
use App\Parameters\Commands\CreateParameterCommand;
use App\Parameters\Repositories\ParameterRepositoryInterface;

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
