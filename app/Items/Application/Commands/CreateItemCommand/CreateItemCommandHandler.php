<?php

declare(strict_types=1);

namespace App\Items\Application\Commands\CreateItemCommand;

use App\Items\Infrastructure\Repositories\ItemRepositoryInterface;
use App\Shared\Application\Commands\CommandHandlerInterface;
use App\Shared\Application\Commands\CommandInterface;
use App\Shared\Application\Commands\IncorrectCommandException;

final readonly class CreateItemCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ItemRepositoryInterface $itemRepository,
    ) {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof CreateItemCommand) {
            throw new IncorrectCommandException(data: ['handler' => self::class, 'currentCommand' => $command::class, 'expectedCommand' => CreateItemCommand::class]);
        }

        $this->itemRepository->create(attributes: ['component_id' => $command->componentId, 'category_id' => $command->categoryId, 'user_id' => $command->userId]);
    }
}
