<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Handlers;

use App\Helpers\AssertHelper;
use App\PlayableItemFields\Commands\UpdatePartiallyPlayableItemFieldCommand;
use App\PlayableItemFields\Exceptions\PlayableItemFieldNotFoundException;
use App\PlayableItemFields\Repositories\PlayableItemFieldRepositoryInterface;
use App\Shared\Commands\CommandInterface;
use App\Shared\Exceptions\Http\IncorrectCommandException;
use App\Shared\Handlers\CommandHandlerInterface;
use App\Shared\Services\ParameterService;

final readonly class UpdatePartiallyPlayableItemFieldHandler implements CommandHandlerInterface
{
    public function __construct(
        private PlayableItemFieldRepositoryInterface $playableItemFieldRepository,
        private ParameterService $parameterService,
    ) {
    }

    public function handle(CommandInterface $command): void
    {
        if (! $command instanceof UpdatePartiallyPlayableItemFieldCommand) {
            throw new IncorrectCommandException(data: ['handler' => self::class, 'currentCommand' => $command::class, 'expectedCommand' => UpdatePartiallyPlayableItemFieldCommand::class]);
        }

        /** @var array{'value': ?string, 'playableItemId': ?string, 'parameterId': ?string} $attributes */
        $attributes = [];

        $value = $command->value;
        $parameterId = $command->parameterId;
        $playableItemId = $command->playableItemId;

        if (! is_null($value) && ! is_null($parameterId)) {
            $attributes['value'] = $this->parameterService->validateValueTypeByParameter(
                parameterId: $parameterId,
                value: $value
            );
            $attributes['parameter_id'] = $parameterId;
        } else {
            if (! is_null($value)) {
                $playableItemField = AssertHelper::isPlayableItemField(
                    $this->playableItemFieldRepository->findById(id: $command->id)
                );
                $parameter = AssertHelper::isParameter($playableItemField->getParameter());
                $attributes['value'] = $this->parameterService->validateValueTypeByType(
                    type: $parameter->type,
                    value: $value
                );
            }

            if (! is_null($parameterId)) {
                $attributes['parameter_id'] = $parameterId;
            }
        }

        if (! is_null($playableItemId)) {
            $attributes['playableItem_id'] = $playableItemId;
        }

        $isUpdated = $this->playableItemFieldRepository->updateById(id: $command->id, attributes: $attributes);
        if (! $isUpdated) {
            throw new PlayableItemFieldNotFoundException(data: ['id' => $command->id]);
        }
    }
}
