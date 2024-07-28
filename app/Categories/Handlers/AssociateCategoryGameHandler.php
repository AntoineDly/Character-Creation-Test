<?php

declare(strict_types=1);

namespace App\Categories\Handlers;

use App\Base\Commands\CommandInterface;
use App\Base\Exceptions\IncorrectCommandException;
use App\Base\Handlers\CommandHandlerInterface;
use App\Categories\Commands\AssociateCategoryGameCommand;
use App\Categories\Repositories\CategoryRepositoryInterface;

final readonly class AssociateCategoryGameHandler implements CommandHandlerInterface
{
    public function __construct(private CategoryRepositoryInterface $categoryRepository)
    {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof AssociateCategoryGameCommand) {
            throw new IncorrectCommandException('Command must be an instance of AssociateCategoryGameCommand');
        }

        $this->categoryRepository->associateGame(categoryId: $command->categoryId, gameId: $command->gameId);
    }
}
