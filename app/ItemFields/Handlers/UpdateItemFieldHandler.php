<?php

declare(strict_types=1);

namespace App\ItemFields\Handlers;

use App\ItemFields\Commands\UpdateItemFieldCommand;
use App\ItemFields\Exceptions\ItemFieldNotFoundException;
use App\ItemFields\Repositories\ItemFieldRepositoryInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Exceptions\Http\IncorrectCommandException;
use App\Shared\Handlers\CommandHandlerInterface;
use App\Shared\Services\ParameterService;

final readonly class UpdateItemFieldHandler implements CommandHandlerInterface
{
    public function __construct(
        private ItemFieldRepositoryInterface $itemFieldRepository,
        private ParameterService $parameterService,
    ) {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof UpdateItemFieldCommand) {
            throw new IncorrectCommandException(data: ['handler' => self::class, 'currentCommand' => $command::class, 'expectedCommand' => UpdateItemFieldCommand::class]);
        }

        $value = $this->parameterService->validateValueTypeByParameter(parameterId: $command->parameterId, value: $command->value);

        $isUpdated = $this->itemFieldRepository->updateById(id: $command->id, attributes: ['value' => $value, 'item_id' => $command->itemId, 'parameter_id' => $command->parameterId]);
        if (! $isUpdated) {
            throw new ItemFieldNotFoundException(data: ['id' => $command->id]);
        }
    }
}
