<?php

declare(strict_types=1);

namespace App\DefaultItemFields\Handlers;

use App\DefaultItemFields\Commands\UpdatePartiallyDefaultItemFieldCommand;
use App\DefaultItemFields\Exceptions\DefaultItemFieldNotFoundException;
use App\DefaultItemFields\Repositories\DefaultItemFieldRepositoryInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Exceptions\Http\IncorrectCommandException;
use App\Shared\Handlers\CommandHandlerInterface;
use App\Shared\Services\ParameterService;

final readonly class UpdatePartiallyDefaultItemFieldHandler implements CommandHandlerInterface
{
    public function __construct(
        private DefaultItemFieldRepositoryInterface $defaultItemFieldRepository,
        private ParameterService $parameterService,
    ) {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof UpdatePartiallyDefaultItemFieldCommand) {
            throw new IncorrectCommandException('Command must be an instance of UpdatePartiallyDefaultItemFieldCommand');
        }

        /** @var array{'value': ?string, 'linkedItemId': ?string, 'parameterId': ?string} $attributes */
        $attributes = [];

        if (! is_null($command->value) && ! is_null($command->parameterId)) {
            $value = $this->parameterService->validateValueTypeByParameter(parameterId: $command->parameterId, value: $command->value);

            $attributes['value'] = $value;
        }

        if (! is_null($command->parameterId)) {
            $attributes['parameter_id'] = $command->parameterId;
        }

        $isUpdated = $this->defaultItemFieldRepository->updateById(id: $command->id, attributes: $attributes);
        if (! $isUpdated) {
            throw new DefaultItemFieldNotFoundException(message: 'Default Item Field not found with id : '.$command->id);
        }
    }
}
