<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Application\Commands\CreateLinkedItemFieldCommand;

use App\LinkedItemFields\Infrastructure\Repositories\LinkedItemFieldRepositoryInterface;
use App\Parameters\Domain\Services\ParameterService;
use App\Shared\Commands\CommandHandlerInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Http\Exceptions\IncorrectCommandException;

final readonly class CreateLinkedItemFieldCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private LinkedItemFieldRepositoryInterface $fieldRepository,
        private ParameterService $parameterService,
    ) {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof CreateLinkedItemFieldCommand) {
            throw new IncorrectCommandException(data: ['handler' => self::class, 'currentCommand' => $command::class, 'expectedCommand' => CreateLinkedItemFieldCommand::class]);
        }

        $value = $this->parameterService->validateValueTypeByParameter(parameterId: $command->parameterId, value: $command->value);

        $this->fieldRepository->create(attributes: ['value' => $value, 'linked_item_id' => $command->linkedItemId, 'parameter_id' => $command->parameterId, 'user_id' => $command->userId]);
    }
}
