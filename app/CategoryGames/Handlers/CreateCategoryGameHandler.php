<?php

declare(strict_types=1);

namespace App\CategoryGames\Handlers;

use App\Categories\Repositories\CategoryRepositoryInterface;
use App\CategoryGames\Commands\CreateCategoryGameCommand;
use App\Shared\Commands\CommandInterface;
use App\Shared\Handlers\CommandHandlerInterface;
use App\Shared\Http\Exceptions\IncorrectCommandException;

final readonly class CreateCategoryGameHandler implements CommandHandlerInterface
{
    public function __construct(private CategoryRepositoryInterface $categoryRepository)
    {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof CreateCategoryGameCommand) {
            throw new IncorrectCommandException(data: ['handler' => self::class, 'currentCommand' => $command::class, 'expectedCommand' => CreateCategoryGameCommand::class]);
        }

        $this->categoryRepository->associateGame(categoryId: $command->categoryId, gameId: $command->gameId);
    }
}
