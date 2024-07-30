<?php

declare(strict_types=1);

namespace App\Items\Handlers;

use App\Base\Commands\CommandInterface;
use App\Base\Exceptions\IncorrectCommandException;
use App\Base\Handlers\CommandHandlerInterface;
use App\Items\Commands\AssociateItemCategoryCommand;
use App\Items\Repositories\ItemRepositoryInterface;

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
