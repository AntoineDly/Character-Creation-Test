<?php

declare(strict_types=1);

namespace App\Character\Handlers;

use App\Character\Commands\CreateCharacterCommand;
use App\Character\Repositories\CharacterRepositoryInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Exceptions\IncorrectCommandException;
use App\Shared\Handlers\CommandHandlerInterface;

final readonly class CreateCharacterHandler implements CommandHandlerInterface
{
    public function __construct(private CharacterRepositoryInterface $characterRepository)
    {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof CreateCharacterCommand) {
            throw new IncorrectCommandException('Command must be an instance of CreateCharacterCommand');
        }

        $this->characterRepository->create(attributes: ['name' => $command->name, 'game_id' => $command->gameId, 'user_id' => $command->userId]);
    }
}
