<?php

declare(strict_types=1);

namespace App\Parameters\Application\Commands\CreateParameterCommand;

use App\Parameters\Infrastructure\Repositories\ParameterRepositoryInterface;
use App\Shared\Commands\CommandHandlerInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Http\Exceptions\IncorrectCommandException;

final readonly class CreateParameterCommandHandler implements CommandHandlerInterface
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
