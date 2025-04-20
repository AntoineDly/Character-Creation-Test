<?php

declare(strict_types=1);

namespace App\Games\Handlers;

use App\Games\Commands\UpdateGameCommand;
use App\Games\Exceptions\GameNotFoundException;
use App\Games\Repositories\GameRepositoryInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Handlers\CommandHandlerInterface;
use App\Shared\Http\Exceptions\IncorrectCommandException;

final readonly class UpdateGameHandler implements CommandHandlerInterface
{
    public function __construct(private GameRepositoryInterface $gameRepository)
    {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof UpdateGameCommand) {
            throw new IncorrectCommandException(data: ['handler' => self::class, 'currentCommand' => $command::class, 'expectedCommand' => UpdateGameCommand::class]);
        }

        $isUpdated = $this->gameRepository->updateById(
            id: $command->id,
            attributes: ['name' => $command->name, 'visible_for_all' => $command->visibleForAll]
        );
        if (! $isUpdated) {
            throw new GameNotFoundException(data: ['id' => $command->id]);
        }
    }
}
