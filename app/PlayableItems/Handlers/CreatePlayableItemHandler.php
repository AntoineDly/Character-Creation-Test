<?php

declare(strict_types=1);

namespace App\PlayableItems\Handlers;

use App\PlayableItems\Commands\CreatePlayableItemCommand;
use App\PlayableItems\Repositories\PlayableItemRepositoryInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Handlers\CommandHandlerInterface;
use App\Shared\Http\Exceptions\IncorrectCommandException;

final readonly class CreatePlayableItemHandler implements CommandHandlerInterface
{
    public function __construct(private PlayableItemRepositoryInterface $playableItemRepository)
    {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof CreatePlayableItemCommand) {
            throw new IncorrectCommandException(data: ['handler' => self::class, 'currentCommand' => $command::class, 'expectedCommand' => CreatePlayableItemCommand::class]);
        }

        $this->playableItemRepository->create(['item_id' => $command->itemId, 'game_id' => $command->gameId, 'user_id' => $command->userId]);
    }
}
