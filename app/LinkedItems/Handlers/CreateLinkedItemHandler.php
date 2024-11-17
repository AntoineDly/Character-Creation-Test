<?php

declare(strict_types=1);

namespace App\LinkedItems\Handlers;

use App\LinkedItems\Commands\CreateLinkedItemCommand;
use App\LinkedItems\Repositories\LinkedItemRepositoryInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Exceptions\Http\IncorrectCommandException;
use App\Shared\Handlers\CommandHandlerInterface;

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

        $this->linkedItemRepository->create(attributes: ['item_id' => $command->itemId, 'character_id' => $command->characterId, 'user_id' => $command->userId]);
    }
}
