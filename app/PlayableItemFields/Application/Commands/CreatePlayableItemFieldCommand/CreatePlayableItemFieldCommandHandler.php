<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Application\Commands\CreatePlayableItemFieldCommand;

use App\Parameters\Domain\Services\ParameterService;
use App\PlayableItemFields\Infrastructure\Repositories\PlayableItemFieldRepositoryInterface;
use App\Shared\Application\Commands\CommandHandlerInterface;
use App\Shared\Application\Commands\CommandInterface;
use App\Shared\Application\Commands\IncorrectCommandException;

final readonly class CreatePlayableItemFieldCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private PlayableItemFieldRepositoryInterface $playableItemFieldRepository,
        private ParameterService $parameterService,
    ) {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof CreatePlayableItemFieldCommand) {
            throw new IncorrectCommandException(data: ['handler' => self::class, 'currentCommand' => $command::class, 'expectedCommand' => CreatePlayableItemFieldCommand::class]);
        }

        $value = $this->parameterService->validateValueTypeByParameter(parameterId: $command->parameterId, value: $command->value);

        $this->playableItemFieldRepository->create(attributes: ['value' => $value, 'playableItem_id' => $command->playableItemId, 'parameter_id' => $command->parameterId, 'user_id' => $command->userId]);
    }
}
