<?php

declare(strict_types=1);

namespace App\Categories\Handlers;

use App\Base\Commands\CommandInterface;
use App\Base\Exceptions\IncorrectCommandException;
use App\Base\Handlers\CommandHandlerInterface;
use App\Categories\Commands\CreateCategoryCommand;
use App\Categories\Repositories\CategoryRepositoryInterface;

final readonly class CreateCategoryHandler implements CommandHandlerInterface
{
    public function __construct(private CategoryRepositoryInterface $characterRepository)
    {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof CreateCategoryCommand) {
            throw new IncorrectCommandException('Command must be an instance of CreateCategoryCommand');
        }

        $this->characterRepository->create(attributes: ['name' => $command->name, 'user_id' => $command->userId]);
    }
}
