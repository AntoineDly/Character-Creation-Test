<?php

declare(strict_types=1);

namespace App\Characters\Application\Commands\CreateCharacterCommand;

use App\Characters\Infrastructure\Repositories\CharacterRepositoryInterface;
use App\Shared\Commands\CommandHandlerInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Http\Exceptions\IncorrectCommandException;

final readonly class CreateCharacterCommandHandler implements CommandHandlerInterface
{
    public function __construct(private CharacterRepositoryInterface $characterRepository)
    {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof CreateCharacterCommand) {
            throw new IncorrectCommandException(data: ['handler' => self::class, 'currentCommand' => $command::class, 'expectedCommand' => CreateCharacterCommand::class]);
        }

        $this->characterRepository->create(attributes: ['game_id' => $command->gameId, 'user_id' => $command->userId]);
    }
}
