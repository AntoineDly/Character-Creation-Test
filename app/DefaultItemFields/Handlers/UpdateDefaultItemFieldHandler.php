<?php

declare(strict_types=1);

namespace App\DefaultItemFields\Handlers;

use App\DefaultItemFields\Commands\UpdateDefaultItemFieldCommand;
use App\DefaultItemFields\Exceptions\DefaultItemFieldNotFoundException;
use App\DefaultItemFields\Repositories\DefaultItemFieldRepositoryInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Exceptions\Http\IncorrectCommandException;
use App\Shared\Handlers\CommandHandlerInterface;
use App\Shared\Services\ParameterService;

final readonly class UpdateDefaultItemFieldHandler implements CommandHandlerInterface
{
    public function __construct(
        private DefaultItemFieldRepositoryInterface $defaultItemFieldRepository,
        private ParameterService $parameterService,
    ) {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof UpdateDefaultItemFieldCommand) {
            throw new IncorrectCommandException('Command must be an instance of UpdateDefaultItemFieldCommand');
        }

        $value = $this->parameterService->validateValueTypeByParameter(parameterId: $command->parameterId, value: $command->value);

        $isUpdated = $this->defaultItemFieldRepository->updateById(id: $command->id, attributes: ['value' => $value, 'item_id' => $command->itemId, 'parameter_id' => $command->parameterId]);
        if (! $isUpdated) {
            throw new DefaultItemFieldNotFoundException(message: 'Default Item Field not found with id : '.$command->id);
        }
    }
}
