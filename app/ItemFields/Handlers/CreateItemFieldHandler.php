<?php

declare(strict_types=1);

namespace App\ItemFields\Handlers;

use App\ItemFields\Commands\CreateItemFieldCommand;
use App\ItemFields\Repositories\ItemFieldRepositoryInterface;
use App\Parameters\Services\ParameterService;
use App\Shared\Commands\CommandInterface;
use App\Shared\Handlers\CommandHandlerInterface;
use App\Shared\Http\Exceptions\IncorrectCommandException;

final readonly class CreateItemFieldHandler implements CommandHandlerInterface
{
    public function __construct(
        private ItemFieldRepositoryInterface $itemFieldRepository,
        private ParameterService $parameterService,
    ) {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof CreateItemFieldCommand) {
            throw new IncorrectCommandException(data: ['handler' => self::class, 'currentCommand' => $command::class, 'expectedCommand' => CreateItemFieldCommand::class]);
        }

        $value = $this->parameterService->validateValueTypeByParameter(parameterId: $command->parameterId, value: $command->value);

        $this->itemFieldRepository->create(attributes: ['value' => $value, 'item_id' => $command->itemId, 'parameter_id' => $command->parameterId, 'user_id' => $command->userId]);
    }
}
