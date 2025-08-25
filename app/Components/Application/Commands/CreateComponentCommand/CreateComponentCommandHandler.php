<?php

declare(strict_types=1);

namespace App\Components\Application\Commands\CreateComponentCommand;

use App\Components\Infrastructure\Repositories\ComponentRepositoryInterface;
use App\Shared\Application\Commands\CommandHandlerInterface;
use App\Shared\Application\Commands\CommandInterface;
use App\Shared\Application\Commands\IncorrectCommandException;

final readonly class CreateComponentCommandHandler implements CommandHandlerInterface
{
    public function __construct(private ComponentRepositoryInterface $componentRepository)
    {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof CreateComponentCommand) {
            throw new IncorrectCommandException(data: ['handler' => self::class, 'currentCommand' => $command::class, 'expectedCommand' => CreateComponentCommand::class]);
        }

        $this->componentRepository->create(['user_id' => $command->userId]);
    }
}
