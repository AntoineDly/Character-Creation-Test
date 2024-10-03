<?php

declare(strict_types=1);

namespace App\Characters\Repositories;

use App\Characters\Exceptions\CharacterNotFoundException;
use App\Characters\Models\Character;
use App\Helpers\AssertHelper;
use App\Shared\Exceptions\InvalidClassException;
use App\Shared\Repositories\AbstractRepository\AbstractRepository;

final readonly class CharacterRepository extends AbstractRepository implements CharacterRepositoryInterface
{
    public function __construct(Character $model)
    {
        parent::__construct($model);
    }

    /**
     * @throws CharacterNotFoundException
     * @throws InvalidClassException
     */
    public function getCharacterWithLinkedItemsById(string $id): Character
    {
        $character = $this->model->query()->where('id', $id)
            ->with(
                [
                    'game.categories',
                    'linkedItems.fields.parameter',
                    'linkedItems.item.defaultItemFields.parameter',
                    'linkedItems.item.component.defaultComponentFields.parameter',
                    'linkedItems.item.category',
                ]
            )->sole();

        return AssertHelper::isCharacter($character);
    }

    /**
     * @throws CharacterNotFoundException
     * @throws InvalidClassException
     */
    public function getCharacterWithGameById(string $id): Character
    {
        $character = $this->model->query()->where('id', $id)->with('game')->sole();

        return AssertHelper::isCharacter($character);
    }
}
