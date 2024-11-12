<?php

declare(strict_types=1);

namespace App\DefaultItemFields\Handlers;

use App\DefaultItemFields\Commands\UpdatePartiallyDefaultItemFieldCommand;
use App\DefaultItemFields\Exceptions\DefaultItemFieldNotFoundException;
use App\DefaultItemFields\Repositories\DefaultItemFieldRepositoryInterface;
use App\Helpers\AssertHelper;
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
        $value = $command->value;
        $parameterId = $command->parameterId;
        $itemId = $command->itemId;

        if (! is_null($value) && ! is_null($parameterId)) {
            $attributes['value'] = $this->parameterService->validateValueTypeByParameter(
                parameterId: $parameterId,
                value: $value
            );
            $attributes['parameter_id'] = $parameterId;
        } else {
            if (! is_null($value)) {
                $defaultItemField = AssertHelper::isDefaultItemField(
                    $this->defaultItemFieldRepository->findById(id: $command->id)
                );
                $parameter = AssertHelper::isParameter($defaultItemField->getParameter());
                $attributes['value'] = $this->parameterService->validateValueTypeByType(
                    type: $parameter->type,
                    value: $value
                );
            }

            if (! is_null($parameterId)) {
                $attributes['parameter_id'] = $parameterId;
            }
        }

        if (! is_null($itemId)) {
            $attributes['item_id'] = $itemId;
        }

        $isUpdated = $this->defaultItemFieldRepository->updateById(id: $command->id, attributes: $attributes);
        if (! $isUpdated) {
            throw new DefaultItemFieldNotFoundException(data: ['id' => $command->id]);
        }
    }
}
