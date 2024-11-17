<?php

declare(strict_types=1);

namespace App\DefaultComponentFields\Handlers;

use App\DefaultComponentFields\Commands\UpdatePartiallyDefaultComponentFieldCommand;
use App\DefaultComponentFields\Exceptions\DefaultComponentFieldNotFoundException;
use App\DefaultComponentFields\Repositories\DefaultComponentFieldRepositoryInterface;
use App\Helpers\AssertHelper;
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
            throw new IncorrectCommandException(data: ['handler' => self::class, 'currentCommand' => $command::class, 'expectedCommand' => UpdatePartiallyDefaultComponentFieldCommand::class]);
        }

        /** @var array{'value': ?string, 'componentId': ?string, 'parameterId': ?string} $attributes */
        $attributes = [];

        $value = $command->value;
        $parameterId = $command->parameterId;
        $componentId = $command->componentId;

        if (! is_null($value) && ! is_null($parameterId)) {
            $attributes['value'] = $this->parameterService->validateValueTypeByParameter(
                parameterId: $parameterId,
                value: $value
            );
            $attributes['parameter_id'] = $parameterId;
        } else {
            if (! is_null($value)) {
                $defaultComponentField = AssertHelper::isDefaultComponentField(
                    $this->defaultComponentFieldRepository->findById(id: $command->id)
                );
                $parameter = AssertHelper::isParameter($defaultComponentField->getParameter());
                $attributes['value'] = $this->parameterService->validateValueTypeByType(
                    type: $parameter->type,
                    value: $value
                );
            }

            if (! is_null($parameterId)) {
                $attributes['parameter_id'] = $parameterId;
            }
        }

        if (! is_null($componentId)) {
            $attributes['component_id'] = $componentId;
        }

        $isUpdated = $this->defaultComponentFieldRepository->updateById(id: $command->id, attributes: $attributes);
        if (! $isUpdated) {
            throw new DefaultComponentFieldNotFoundException(data: ['id' => $command->id]);
        }
    }
}
