<?php

declare(strict_types=1);

namespace App\Characters\Repositories;

use App\Characters\Exceptions\CharacterNotFoundException;
use App\Characters\Models\Character;
use App\Helpers\AssertHelper;
use App\Shared\Http\Exceptions\InvalidClassException;
use App\Shared\Repositories\RepositoryTrait;

final readonly class CharacterRepository implements CharacterRepositoryInterface
{
    use RepositoryTrait;

    public function __construct(Character $model)
    {
        $this->model = $model;
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
                    'linkedItems.linkedItemFields.parameter',
                    'linkedItems.playableItem.playableItemFields.parameter',
                    'linkedItems.playableItem.item.itemFields.parameter',
                    'linkedItems.playableItem.item.component.componentFields.parameter',
                    'linkedItems.playableItem.item.category',
                ]
            )->first();

        return AssertHelper::isCharacter($character);
    }

    /**
     * @throws CharacterNotFoundException
     * @throws InvalidClassException
     */
    public function getCharacterWithGameById(string $id): Character
    {
        $character = $this->model->query()->where('id', $id)->with('game')->first();

        return AssertHelper::isCharacter($character);
    }
}
