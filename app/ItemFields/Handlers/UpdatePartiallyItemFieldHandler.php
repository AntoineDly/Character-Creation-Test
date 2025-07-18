<?php

declare(strict_types=1);

namespace App\ItemFields\Handlers;

use App\Helpers\AssertHelper;
use App\ItemFields\Commands\UpdatePartiallyItemFieldCommand;
use App\ItemFields\Exceptions\ItemFieldNotFoundException;
use App\ItemFields\Repositories\ItemFieldRepositoryInterface;
use App\Parameters\Services\ParameterService;
use App\Shared\Commands\CommandInterface;
use App\Shared\Handlers\CommandHandlerInterface;
use App\Shared\Http\Exceptions\IncorrectCommandException;

final readonly class UpdatePartiallyItemFieldHandler implements CommandHandlerInterface
{
    public function __construct(
        private ItemFieldRepositoryInterface $itemFieldRepository,
        private ParameterService $parameterService,
    ) {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof UpdatePartiallyItemFieldCommand) {
            throw new IncorrectCommandException(data: ['handler' => self::class, 'currentCommand' => $command::class, 'expectedCommand' => UpdatePartiallyItemFieldCommand::class]);
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
                $itemField = AssertHelper::isItemFieldNotNull(
                    $this->itemFieldRepository->findById(id: $command->id)
                );
                $parameter = AssertHelper::isParameterNotNull($itemField->getParameter());
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

        $isUpdated = $this->itemFieldRepository->updateById(id: $command->id, attributes: $attributes);
        if (! $isUpdated) {
            throw new ItemFieldNotFoundException(data: ['id' => $command->id]);
        }
    }
}
