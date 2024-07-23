<?php

declare(strict_types=1);

namespace App\Game\Handlers;

use App\Base\Commands\CommandInterface;
use App\Base\Exceptions\IncorrectCommandException;
use App\Base\Handlers\CommandHandlerInterface;
use App\Game\Commands\CreateGameCommand;
use App\Game\Repositories\GameRepositoryInterface;

final readonly class CreateGameHandler implements CommandHandlerInterface
{
    public function __construct(private GameRepositoryInterface $gameRepository)
    {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof CreateGameCommand) {
            throw new IncorrectCommandException('Command must be an instance of CreateGameCommand');
        }

        $this->gameRepository->create(['name' => $command->name, 'visible_for_all' => $command->visibleForAll, 'user_id' => $command->userId]);
    }
}
