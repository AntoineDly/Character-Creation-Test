<?php

declare(strict_types=1);

namespace App\Games\Handlers;

use App\Games\Commands\CreateGameCommand;
use App\Games\Repositories\GameRepositoryInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Handlers\CommandHandlerInterface;
use App\Shared\Http\Exceptions\IncorrectCommandException;

final readonly class CreateGameHandler implements CommandHandlerInterface
{
    public function __construct(private GameRepositoryInterface $gameRepository)
    {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof CreateGameCommand) {
            throw new IncorrectCommandException(data: ['handler' => self::class, 'currentCommand' => $command::class, 'expectedCommand' => CreateGameCommand::class]);
        }

        $this->gameRepository->create(['name' => $command->name, 'visible_for_all' => $command->visibleForAll, 'user_id' => $command->userId]);
    }
}
