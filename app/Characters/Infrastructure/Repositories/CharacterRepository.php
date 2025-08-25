<?php

declare(strict_types=1);

namespace App\Characters\Infrastructure\Repositories;

use App\Characters\Domain\Models\Character;
use App\Helpers\AssertHelper;
use App\Shared\Infrastructure\Repositories\RepositoryTrait;

final readonly class CharacterRepository implements CharacterRepositoryInterface
{
    /** @use RepositoryTrait<Character> */
    use RepositoryTrait;

    public function __construct(Character $model)
    {
        $this->model = $model;
    }

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

        return AssertHelper::isCharacterNotNull($character);
    }

    public function getCharacterWithGameById(string $id): Character
    {
        $character = $this->model->query()->where('id', $id)->with('game')->first();

        return AssertHelper::isCharacterNotNull($character);
    }
}
