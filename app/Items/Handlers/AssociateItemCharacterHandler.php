<?php

declare(strict_types=1);

namespace App\Items\Handlers;

use App\Base\Commands\CommandInterface;
use App\Base\Exceptions\IncorrectCommandException;
use App\Base\Handlers\CommandHandlerInterface;
use App\Items\Commands\AssociateItemCharacterCommand;
use App\Items\Repositories\ItemRepositoryInterface;

final readonly class AssociateItemCharacterHandler implements CommandHandlerInterface
{
    public function __construct(private ItemRepositoryInterface $itemRepository)
    {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof AssociateItemCharacterCommand) {
            throw new IncorrectCommandException('Command must be an instance of AssociateItemCharacterCommand');
        }

        $this->itemRepository->associateCharacter(itemId: $command->itemId, characterId: $command->characterId);
    }
}
