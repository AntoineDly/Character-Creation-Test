<?php

declare(strict_types=1);

namespace App\Items\Handlers;

use App\Items\Commands\AssociateItemGameCommand;
use App\Items\Repositories\ItemRepositoryInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Exceptions\IncorrectCommandException;
use App\Shared\Handlers\CommandHandlerInterface;

final readonly class AssociateItemGameHandler implements CommandHandlerInterface
{
    public function __construct(private ItemRepositoryInterface $itemRepository)
    {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof AssociateItemGameCommand) {
            throw new IncorrectCommandException('Command must be an instance of AssociateItemGameCommand');
        }

        $this->itemRepository->associateGame(itemId: $command->itemId, gameId: $command->gameId);
    }
}
