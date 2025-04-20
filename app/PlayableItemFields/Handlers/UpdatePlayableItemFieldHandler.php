<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Handlers;

use App\Parameters\Services\ParameterService;
use App\PlayableItemFields\Commands\UpdatePlayableItemFieldCommand;
use App\PlayableItemFields\Exceptions\PlayableItemFieldNotFoundException;
use App\PlayableItemFields\Repositories\PlayableItemFieldRepositoryInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Handlers\CommandHandlerInterface;
use App\Shared\Http\Exceptions\IncorrectCommandException;

final readonly class UpdatePlayableItemFieldHandler implements CommandHandlerInterface
{
    public function __construct(
        private PlayableItemFieldRepositoryInterface $playableItemFieldRepository,
        private ParameterService $parameterService,
    ) {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof UpdatePlayableItemFieldCommand) {
            throw new IncorrectCommandException(data: ['handler' => self::class, 'currentCommand' => $command::class, 'expectedCommand' => UpdatePlayableItemFieldCommand::class]);
        }

        $value = $this->parameterService->validateValueTypeByParameter(parameterId: $command->parameterId, value: $command->value);

        $isUpdated = $this->playableItemFieldRepository->updateById(id: $command->id, attributes: ['value' => $value, 'playableItem_id' => $command->playableItemId, 'parameter_id' => $command->parameterId]);
        if (! $isUpdated) {
            throw new PlayableItemFieldNotFoundException(data: ['id' => $command->id]);
        }
    }
}
