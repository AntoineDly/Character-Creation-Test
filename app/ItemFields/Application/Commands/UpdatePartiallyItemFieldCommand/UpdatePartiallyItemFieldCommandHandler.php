<?php

declare(strict_types=1);

namespace App\ItemFields\Application\Commands\UpdatePartiallyItemFieldCommand;

use App\Helpers\AssertHelper;
use App\ItemFields\Infrastructure\Exceptions\ItemFieldNotFoundException;
use App\ItemFields\Infrastructure\Repositories\ItemFieldRepositoryInterface;
use App\Parameters\Domain\Services\ParameterService;
use App\Shared\Application\Commands\CommandHandlerInterface;
use App\Shared\Application\Commands\CommandInterface;
use App\Shared\Application\Commands\IncorrectCommandException;

final readonly class UpdatePartiallyItemFieldCommandHandler implements CommandHandlerInterface
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
