<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Application\Commands\UpdatePlayableItemFieldCommand;

use App\Parameters\Domain\Services\ParameterService;
use App\PlayableItemFields\Infrastructure\Exceptions\PlayableItemFieldNotFoundException;
use App\PlayableItemFields\Infrastructure\Repositories\PlayableItemFieldRepositoryInterface;
use App\Shared\Application\Commands\CommandHandlerInterface;
use App\Shared\Application\Commands\CommandInterface;
use App\Shared\Application\Commands\IncorrectCommandException;

final readonly class UpdatePlayableItemFieldCommandHandler implements CommandHandlerInterface
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

        $isUpdated = $this->playableItemFieldRepository->updateById(id: $command->id, attributes: ['value' => $value, 'playable_item_id' => $command->playableItemId, 'parameter_id' => $command->parameterId]);
        if (! $isUpdated) {
            throw new PlayableItemFieldNotFoundException(data: ['id' => $command->id]);
        }
    }
}
