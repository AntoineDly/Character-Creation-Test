<?php

declare(strict_types=1);

namespace App\LinkedItems\Handlers;

use App\LinkedItems\Commands\CreateLinkedItemCommand;
use App\LinkedItems\Repositories\LinkedItemRepositoryInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Handlers\CommandHandlerInterface;
use App\Shared\Http\Exceptions\IncorrectCommandException;

final readonly class CreateLinkedItemHandler implements CommandHandlerInterface
{
    public function __construct(
        private LinkedItemRepositoryInterface $linkedItemRepository,
    ) {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof CreateLinkedItemCommand) {
            throw new IncorrectCommandException(data: ['handler' => self::class, 'currentCommand' => $command::class, 'expectedCommand' => CreateLinkedItemCommand::class]);
        }

        $this->linkedItemRepository->create(attributes: ['playable_item_id' => $command->playableItemId, 'character_id' => $command->characterId, 'user_id' => $command->userId]);
    }
}
