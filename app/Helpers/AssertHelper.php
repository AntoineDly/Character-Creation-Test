<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Categories\Exceptions\CategoryNotFoundException;
use App\Categories\Models\Category;
use App\Characters\Exceptions\CharacterNotFoundException;
use App\Characters\Models\Character;
use App\ComponentFields\Exceptions\ComponentFieldNotFoundException;
use App\ComponentFields\Models\ComponentField;
use App\Components\Exceptions\ComponentNotFoundException;
use App\Components\Models\Component;
use App\Games\Exceptions\GameNotFoundException;
use App\Games\Models\Game;
use App\ItemFields\Exceptions\ItemFieldNotFoundException;
use App\ItemFields\Models\ItemField;
use App\Items\Exceptions\ItemNotFoundException;
use App\Items\Models\Item;
use App\LinkedItemFields\Exceptions\LinkedItemFieldNotFoundException;
use App\LinkedItemFields\Models\LinkedItemField;
use App\LinkedItems\Exceptions\LinkedItemNotFoundException;
use App\LinkedItems\Models\LinkedItem;
use App\Parameters\Exceptions\ParameterNotFoundException;
use App\Parameters\Models\Parameter;
use App\PlayableItemFields\Exceptions\PlayableItemFieldNotFoundException;
use App\PlayableItemFields\Models\PlayableItemField;
use App\PlayableItems\Exceptions\PlayableItemNotFoundException;
use App\PlayableItems\Models\PlayableItem;
use App\Shared\Exceptions\Http\InvalidClassException;
use App\Shared\Fields\Exceptions\FieldInterfaceNotFoundException;
use App\Shared\Fields\Interfaces\FieldInterface;
use Illuminate\Database\Eloquent\Model;

final readonly class AssertHelper
{
    public static function isCharacter(?Model $character): Character
    {
        if (is_null($character)) {
            throw new CharacterNotFoundException();
        }

        if (! $character instanceof Character) {
            throw new InvalidClassException(data: ['expectedClass' => Character::class, 'currentClass' => $character::class]);
        }

        return $character;
    }

    public static function isGame(?Model $game): Game
    {
        if (is_null($game)) {
            throw new GameNotFoundException();
        }

        if (! $game instanceof Game) {
            throw new InvalidClassException(data: ['expectedClass' => Game::class, 'currentClass' => $game::class]);
        }

        return $game;
    }

    public static function isCategory(?Model $category): Category
    {
        if (is_null($category)) {
            throw new CategoryNotFoundException();
        }

        if (! $category instanceof Category) {
            throw new InvalidClassException(data: ['expectedClass' => Category::class, 'currentClass' => $category::class]);
        }

        return $category;
    }

    public static function isComponent(?Model $component): Component
    {
        if (is_null($component)) {
            throw new ComponentNotFoundException();
        }

        if (! $component instanceof Component) {
            throw new InvalidClassException(data: ['expectedClass' => Component::class, 'currentClass' => $component::class]);
        }

        return $component;
    }

    public static function isItem(?Model $item): Item
    {
        if (is_null($item)) {
            throw new ItemNotFoundException();
        }

        if (! $item instanceof Item) {
            throw new InvalidClassException(data: ['expectedClass' => Item::class, 'currentClass' => $item::class]);
        }

        return $item;
    }

    public static function isPlayableItem(?Model $playableItem): PlayableItem
    {
        if (is_null($playableItem)) {
            throw new PlayableItemNotFoundException();
        }

        if (! $playableItem instanceof PlayableItem) {
            throw new InvalidClassException(data: ['expectedClass' => PlayableItem::class, 'currentClass' => $playableItem::class]);
        }

        return $playableItem;
    }

    public static function isLinkedItem(?Model $linkedItem): LinkedItem
    {
        if (is_null($linkedItem)) {
            throw new LinkedItemNotFoundException();
        }

        if (! $linkedItem instanceof LinkedItem) {
            throw new InvalidClassException(data: ['expectedClass' => LinkedItem::class, 'currentClass' => $linkedItem::class]);
        }

        return $linkedItem;
    }

    public static function isFieldInterface(?Model $fieldInterface): FieldInterface
    {
        if (is_null($fieldInterface)) {
            throw new FieldInterfaceNotFoundException();
        }

        if (! $fieldInterface instanceof FieldInterface) {
            throw new InvalidClassException(data: ['expectedImplementedInterface' => FieldInterface::class, 'currentClass' => $fieldInterface::class]);
        }

        return $fieldInterface;
    }

    public static function isComponentField(?Model $componentField): ComponentField
    {
        if (is_null($componentField)) {
            throw new ComponentFieldNotFoundException();
        }

        if (! $componentField instanceof ComponentField) {
            throw new InvalidClassException(data: ['expectedClass' => ComponentField::class, 'currentClass' => $componentField::class]);
        }

        return $componentField;
    }

    public static function isItemField(?Model $itemField): ItemField
    {
        if (is_null($itemField)) {
            throw new ItemFieldNotFoundException();
        }

        if (! $itemField instanceof ItemField) {
            throw new InvalidClassException(data: ['expectedClass' => ItemField::class, 'currentClass' => $itemField::class]);
        }

        return $itemField;
    }

    public static function isPlayableItemField(?Model $playableItemField): PlayableItemField
    {
        if (is_null($playableItemField)) {
            throw new PlayableItemFieldNotFoundException();
        }

        if (! $playableItemField instanceof PlayableItemField) {
            throw new InvalidClassException(data: ['expectedClass' => PlayableItemField::class, 'currentClass' => $playableItemField::class]);
        }

        return $playableItemField;
    }

    public static function isLinkedItemField(?Model $linkedItemField): LinkedItemField
    {
        if (is_null($linkedItemField)) {
            throw new LinkedItemFieldNotFoundException();
        }

        if (! $linkedItemField instanceof LinkedItemField) {
            throw new InvalidClassException(data: ['expectedClass' => LinkedItemField::class, 'currentClass' => $linkedItemField::class]);
        }

        return $linkedItemField;
    }

    public static function isParameter(?Model $parameter): Parameter
    {
        if (is_null($parameter)) {
            throw new ParameterNotFoundException();
        }

        if (! $parameter instanceof Parameter) {
            throw new InvalidClassException(data: ['expectedClass' => Parameter::class, 'currentClass' => $parameter::class]);
        }

        return $parameter;
    }
}
