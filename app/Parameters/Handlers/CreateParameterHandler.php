<?php

declare(strict_types=1);

namespace App\Parameters\Handlers;

use App\Parameters\Commands\CreateParameterCommand;
use App\Parameters\Repositories\ParameterRepositoryInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Handlers\CommandHandlerInterface;
use App\Shared\Http\Exceptions\IncorrectCommandException;

final readonly class CreateParameterHandler implements CommandHandlerInterface
{
    public function __construct(private ParameterRepositoryInterface $parameterRepository)
    {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof CreateParameterCommand) {
            throw new IncorrectCommandException(data: ['handler' => self::class, 'currentCommand' => $command::class, 'expectedCommand' => CreateParameterCommand::class]);
        }

        $this->parameterRepository->create(attributes: ['name' => $command->name, 'type' => $command->type, 'user_id' => $command->userId]);
    }
}
