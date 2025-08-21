<?php

declare(strict_types=1);

namespace App\ItemFields\Application\Commands\UpdateItemFieldCommand;

use App\ItemFields\Infrastructure\Exceptions\ItemFieldNotFoundException;
use App\ItemFields\Infrastructure\Repositories\ItemFieldRepositoryInterface;
use App\Parameters\Domain\Services\ParameterService;
use App\Shared\Commands\CommandInterface;
use App\Shared\Handlers\CommandHandlerInterface;
use App\Shared\Http\Exceptions\IncorrectCommandException;

final readonly class UpdateItemFieldCommandHandler implements CommandHandlerInterface
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
