<?php

declare(strict_types=1);

namespace App\Categories\Application\Commands\CreateCategoryCommand;

use App\Categories\Infrastructure\Repositories\CategoryRepositoryInterface;
use App\Shared\Commands\CommandHandlerInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Http\Exceptions\IncorrectCommandException;

final readonly class CreateCategoryCommandHandler implements CommandHandlerInterface
{
    public function __construct(private CategoryRepositoryInterface $categoryRepository)
    {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof CreateCategoryCommand) {
            throw new IncorrectCommandException(data: ['handler' => self::class, 'currentCommand' => $command::class, 'expectedCommand' => CreateCategoryCommand::class]);
        }

        $this->categoryRepository->create(attributes: ['name' => $command->name, 'user_id' => $command->userId]);
    }
}
