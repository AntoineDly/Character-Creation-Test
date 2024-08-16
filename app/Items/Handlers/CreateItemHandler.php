<?php

declare(strict_types=1);

namespace App\Items\Handlers;

use App\Items\Commands\CreateItemCommand;
use App\Items\Repositories\ItemRepositoryInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Exceptions\IncorrectCommandException;
use App\Shared\Handlers\CommandHandlerInterface;

final readonly class CreateItemHandler implements CommandHandlerInterface
{
    public function __construct(
        private ItemRepositoryInterface $itemRepository,
    ) {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof CreateItemCommand) {
            throw new IncorrectCommandException('Command must be an instance of CreateItemCommand');
        }

        $this->itemRepository->create(attributes: ['component_id' => $command->componentId, 'category_id' => $command->categoryId, 'user_id' => $command->userId]);
    }
}
