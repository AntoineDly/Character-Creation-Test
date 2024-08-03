<?php

declare(strict_types=1);

namespace App\Items\Handlers;

use App\Items\Commands\AssociateItemCategoryCommand;
use App\Items\Repositories\ItemRepositoryInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Exceptions\IncorrectCommandException;
use App\Shared\Handlers\CommandHandlerInterface;

final readonly class AssociateItemCategoryHandler implements CommandHandlerInterface
{
    public function __construct(private ItemRepositoryInterface $itemRepository)
    {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof AssociateItemCategoryCommand) {
            throw new IncorrectCommandException('Command must be an instance of AssociateItemCategoryCommand');
        }

        $this->itemRepository->associateCategory(itemId: $command->itemId, categoryId: $command->categoryId);
    }
}
