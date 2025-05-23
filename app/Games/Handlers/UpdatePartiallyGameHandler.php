<?php

declare(strict_types=1);

namespace App\Games\Handlers;

use App\Games\Commands\UpdatePartiallyGameCommand;
use App\Games\Exceptions\GameNotFoundException;
use App\Games\Repositories\GameRepositoryInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Handlers\CommandHandlerInterface;
use App\Shared\Http\Exceptions\IncorrectCommandException;

final readonly class UpdatePartiallyGameHandler implements CommandHandlerInterface
{
    public function __construct(private GameRepositoryInterface $gameRepository)
    {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof UpdatePartiallyGameCommand) {
            throw new IncorrectCommandException(data: ['handler' => self::class, 'currentCommand' => $command::class, 'expectedCommand' => UpdatePartiallyGameCommand::class]);
        }

        /** @var array{'name': ?string, 'visibleForAll': ?bool} $attributes */
        $attributes = [];

        if (! is_null($command->name)) {
            $attributes['name'] = $command->name;
        }

        if (! is_null($command->visibleForAll)) {
            $attributes['visible_for_all'] = $command->visibleForAll;
        }

        $isUpdated = $this->gameRepository->updateById(id: $command->id, attributes: $attributes);
        if (! $isUpdated) {
            throw new GameNotFoundException(data: ['id' => $command->id]);
        }
    }
}
