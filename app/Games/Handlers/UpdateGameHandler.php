<?php

declare(strict_types=1);

namespace App\Games\Handlers;

use App\Games\Commands\UpdateGameCommand;
use App\Games\Repositories\GameRepositoryInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Exceptions\IncorrectCommandException;
use App\Shared\Handlers\CommandHandlerInterface;

final readonly class UpdateGameHandler implements CommandHandlerInterface
{
    public function __construct(private GameRepositoryInterface $gameRepository)
    {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof UpdateGameCommand) {
            throw new IncorrectCommandException('Command must be an instance of UpdateGameCommand');
        }

        $this->gameRepository->update(
            key: 'id',
            value: $command->id,
            attributes: ['name' => $command->name, 'visible_for_all' => $command->visibleForAll, 'user_id' => $command->userId]
        );
    }
}
