<?php

declare(strict_types=1);

namespace App\Games\Application\Commands\UpdateGameCommand;

use App\Games\Infrastructure\Exceptions\GameNotFoundException;
use App\Games\Infrastructure\Repositories\GameRepositoryInterface;
use App\Shared\Commands\CommandHandlerInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Http\Exceptions\IncorrectCommandException;

final readonly class UpdateGameCommandHandler implements CommandHandlerInterface
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
