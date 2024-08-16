<?php

declare(strict_types=1);

namespace App\Components\Handlers;

use App\Components\Commands\CreateComponentCommand;
use App\Components\Repositories\ComponentRepositoryInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Exceptions\IncorrectCommandException;
use App\Shared\Handlers\CommandHandlerInterface;

final readonly class CreateComponentHandler implements CommandHandlerInterface
{
    public function __construct(private ComponentRepositoryInterface $componentRepository)
    {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof CreateComponentCommand) {
            throw new IncorrectCommandException('Command must be an instance of CreateComponentCommand');
        }

        $this->componentRepository->create(['name' => $command->name, 'user_id' => $command->userId]);
    }
}
