<?php

declare(strict_types=1);

namespace App\Categories\Handlers;

use App\Categories\Commands\CreateCategoryCommand;
use App\Categories\Repositories\CategoryRepositoryInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Exceptions\IncorrectCommandException;
use App\Shared\Handlers\CommandHandlerInterface;

final readonly class CreateCategoryHandler implements CommandHandlerInterface
{
    public function __construct(private CategoryRepositoryInterface $categoryRepository)
    {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof CreateCategoryCommand) {
            throw new IncorrectCommandException('Command must be an instance of CreateCategoryCommand');
        }

        $this->categoryRepository->create(attributes: ['name' => $command->name, 'user_id' => $command->userId]);
    }
}
