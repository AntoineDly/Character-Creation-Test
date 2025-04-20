<?php

declare(strict_types=1);

namespace App\Components\Handlers;

use App\Components\Commands\CreateComponentCommand;
use App\Components\Repositories\ComponentRepositoryInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Handlers\CommandHandlerInterface;
use App\Shared\Http\Exceptions\IncorrectCommandException;

final readonly class CreateComponentHandler implements CommandHandlerInterface
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
