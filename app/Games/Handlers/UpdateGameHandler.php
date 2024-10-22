<?php

declare(strict_types=1);

namespace App\Games\Handlers;

use App\Games\Commands\UpdateGameCommand;
use App\Games\Exceptions\GameNotFoundException;
use App\Games\Repositories\GameRepositoryInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Exceptions\Http\IncorrectCommandException;
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

        $isUpdated = $this->gameRepository->updateById(
            id: $command->id,
            attributes: ['name' => $command->name, 'visible_for_all' => $command->visibleForAll]
        );
        if (! $isUpdated) {
            throw new GameNotFoundException(message: 'Game not found with id : '.$command->id);
        }
    }
}
