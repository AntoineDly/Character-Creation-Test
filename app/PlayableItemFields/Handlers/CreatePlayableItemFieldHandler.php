<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Handlers;

use App\Parameters\Services\ParameterService;
use App\PlayableItemFields\Commands\CreatePlayableItemFieldCommand;
use App\PlayableItemFields\Repositories\PlayableItemFieldRepositoryInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Handlers\CommandHandlerInterface;
use App\Shared\Http\Exceptions\IncorrectCommandException;

final readonly class CreatePlayableItemFieldHandler implements CommandHandlerInterface
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
