<?php

declare(strict_types=1);

namespace App\LinkedItems\Application\Commands\CreateLinkedItemCommand;

use App\LinkedItems\Infrastructure\Repositories\LinkedItemRepositoryInterface;
use App\Shared\Application\Commands\CommandHandlerInterface;
use App\Shared\Application\Commands\CommandInterface;
use App\Shared\Application\Commands\IncorrectCommandException;

final readonly class CreateLinkedItemCommandHandler implements CommandHandlerInterface
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
