<?php

declare(strict_types=1);

namespace App\Character\Handlers;

use App\Base\Commands\CommandInterface;
use App\Base\Exceptions\IncorrectCommandException;
use App\Base\Exceptions\StringIsEmptyException;
use App\Base\Handlers\CommandHandlerInterface;
use App\Character\Commands\CreateCharacterCommand;
use App\Character\Repositories\CharacterRepository\CharacterRepository;

final readonly class CreateCharacterHandler implements CommandHandlerInterface
{
    public function __construct(private CharacterRepository $characterRepository)
    {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof CreateCharacterCommand) {
            throw new IncorrectCommandException('Command must be an instance of CreateCharacterCommand');
        }

        if ($command->name === '') {
            throw new StringIsEmptyException('name field is empty');
        }

        $this->characterRepository->create(['name' => $command->name]);
    }
}
