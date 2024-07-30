<?php

declare(strict_types=1);

namespace App\Items\Handlers;

use App\Base\Commands\CommandInterface;
use App\Base\Exceptions\IncorrectCommandException;
use App\Base\Handlers\CommandHandlerInterface;
use App\Items\Commands\CreateItemCommand;
use App\Items\Repositories\ItemRepositoryInterface;

final readonly class CreateItemHandler implements CommandHandlerInterface
{
    public function __construct(private ItemRepositoryInterface $itemRepository)
    {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof CreateItemCommand) {
            throw new IncorrectCommandException('Command must be an instance of CreateItemCommand');
        }

        $this->itemRepository->create(['name' => $command->name, 'user_id' => $command->userId]);
    }
}
