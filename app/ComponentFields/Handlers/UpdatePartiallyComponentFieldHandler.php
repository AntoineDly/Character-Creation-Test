<?php

declare(strict_types=1);

namespace App\ComponentFields\Handlers;

use App\ComponentFields\Commands\UpdatePartiallyComponentFieldCommand;
use App\ComponentFields\Exceptions\ComponentFieldNotFoundException;
use App\ComponentFields\Repositories\ComponentFieldRepositoryInterface;
use App\Helpers\AssertHelper;
use App\Parameters\Services\ParameterService;
use App\Shared\Commands\CommandInterface;
use App\Shared\Handlers\CommandHandlerInterface;
use App\Shared\Http\Exceptions\IncorrectCommandException;

final readonly class UpdatePartiallyComponentFieldHandler implements CommandHandlerInterface
{
    public function __construct(
        private ComponentFieldRepositoryInterface $componentFieldRepository,
        private ParameterService $parameterService,
    ) {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof UpdatePartiallyComponentFieldCommand) {
            throw new IncorrectCommandException(data: ['handler' => self::class, 'currentCommand' => $command::class, 'expectedCommand' => UpdatePartiallyComponentFieldCommand::class]);
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
                $componentField = AssertHelper::isComponentField(
                    $this->componentFieldRepository->findById(id: $command->id)
                );
                $parameter = AssertHelper::isParameter($componentField->getParameter());
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

        $isUpdated = $this->componentFieldRepository->updateById(id: $command->id, attributes: $attributes);
        if (! $isUpdated) {
            throw new ComponentFieldNotFoundException(data: ['id' => $command->id]);
        }
    }
}
