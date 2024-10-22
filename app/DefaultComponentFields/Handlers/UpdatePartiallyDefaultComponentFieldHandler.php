<?php

declare(strict_types=1);

namespace App\DefaultComponentFields\Handlers;

use App\DefaultComponentFields\Commands\UpdatePartiallyDefaultComponentFieldCommand;
use App\DefaultComponentFields\Exceptions\DefaultComponentFieldNotFoundException;
use App\DefaultComponentFields\Repositories\DefaultComponentFieldRepositoryInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Exceptions\Http\IncorrectCommandException;
use App\Shared\Handlers\CommandHandlerInterface;
use App\Shared\Services\ParameterService;

final readonly class UpdatePartiallyDefaultComponentFieldHandler implements CommandHandlerInterface
{
    public function __construct(
        private DefaultComponentFieldRepositoryInterface $defaultComponentFieldRepository,
        private ParameterService $parameterService,
    ) {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof UpdatePartiallyDefaultComponentFieldCommand) {
            throw new IncorrectCommandException('Command must be an instance of UpdatePartiallyDefaultComponentFieldCommand');
        }

        /** @var array{'value': ?string, 'linkedItemId': ?string, 'parameterId': ?string} $attributes */
        $attributes = [];

        if (! is_null($command->value) && ! is_null($command->parameterId)) {
            $value = $this->parameterService->validateValueType(parameterId: $command->parameterId, value: $command->value);

            $attributes['value'] = $value;
        }

        if (! is_null($command->parameterId)) {
            $attributes['parameter_id'] = $command->parameterId;
        }

        $isUpdated = $this->defaultComponentFieldRepository->updateById(id: $command->id, attributes: $attributes);
        if (! $isUpdated) {
            throw new DefaultComponentFieldNotFoundException(message: 'Default Component Field not found with id : '.$command->id);
        }
    }
}
