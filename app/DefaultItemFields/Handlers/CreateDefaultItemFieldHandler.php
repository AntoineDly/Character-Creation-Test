<?php

declare(strict_types=1);

namespace App\DefaultItemFields\Handlers;

use App\DefaultItemFields\Commands\CreateDefaultItemFieldCommand;
use App\DefaultItemFields\Repositories\DefaultItemFieldRepositoryInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Exceptions\Http\IncorrectCommandException;
use App\Shared\Handlers\CommandHandlerInterface;
use App\Shared\Services\ParameterService;

final readonly class CreateDefaultItemFieldHandler implements CommandHandlerInterface
{
    public function __construct(
        private DefaultItemFieldRepositoryInterface $defaultItemFieldRepository,
        private ParameterService $parameterService,
    ) {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof CreateDefaultItemFieldCommand) {
            throw new IncorrectCommandException(data: ['handler' => self::class, 'currentCommand' => $command::class, 'expectedCommand' => CreateDefaultItemFieldCommand::class]);
        }

        $value = $this->parameterService->validateValueTypeByParameter(parameterId: $command->parameterId, value: $command->value);

        $this->defaultItemFieldRepository->create(attributes: ['value' => $value, 'item_id' => $command->itemId, 'parameter_id' => $command->parameterId, 'user_id' => $command->userId]);
    }
}
