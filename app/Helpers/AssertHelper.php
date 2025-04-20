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
use App\Shared\Fields\Exceptions\FieldInterfaceNotFoundException;
use App\Shared\Fields\Interfaces\FieldInterface;
use App\Shared\Http\Exceptions\InvalidClassException;
use Illuminate\Database\Eloquent\Model;

final readonly class AssertHelper
{
    /**
     * @template T
     *
     * @param  class-string<T>  $class
     * @return T
     */
    public static function isClass(object $object, string $class)
    {
        if (! $object instanceof $class) {
            throw new InvalidClassException(data: ['expectedClass' => $class, 'currentClass' => get_class($object)]);
        }

        /** @var T $object */
        return $object;
    }

    public static function isCharacter(?Model $character): Character
    {
        if (is_null($character)) {
            throw new CharacterNotFoundException();
        }

        return self::isClass($character, Character::class);
    }

    public static function isGame(?Model $game): Game
    {
        if (is_null($game)) {
            throw new GameNotFoundException();
        }

        return self::isClass($game, Game::class);
    }

    public static function isCategory(?Model $category): Category
    {
        if (is_null($category)) {
            throw new CategoryNotFoundException();
        }

        return self::isClass($category, Category::class);
    }

    public static function isComponent(?Model $component): Component
    {
        if (is_null($component)) {
            throw new ComponentNotFoundException();
        }

        return self::isClass($component, Component::class);
    }

    public static function isItem(?Model $item): Item
    {
        if (is_null($item)) {
            throw new ItemNotFoundException();
        }

        return self::isClass($item, Item::class);
    }

    public static function isPlayableItem(?Model $playableItem): PlayableItem
    {
        if (is_null($playableItem)) {
            throw new PlayableItemNotFoundException();
        }

        return self::isClass($playableItem, PlayableItem::class);
    }

    public static function isLinkedItem(?Model $linkedItem): LinkedItem
    {
        if (is_null($linkedItem)) {
            throw new LinkedItemNotFoundException();
        }

        return self::isClass($linkedItem, LinkedItem::class);
    }

    public static function isFieldInterface(?Model $fieldInterface): FieldInterface
    {
        if (is_null($fieldInterface)) {
            throw new FieldInterfaceNotFoundException();
        }

        return self::isClass($fieldInterface, FieldInterface::class);
    }

    public static function isComponentField(?Model $componentField): ComponentField
    {
        if (is_null($componentField)) {
            throw new ComponentFieldNotFoundException();
        }

        return self::isClass($componentField, ComponentField::class);
    }

    public static function isItemField(?Model $itemField): ItemField
    {
        if (is_null($itemField)) {
            throw new ItemFieldNotFoundException();
        }

        return self::isClass($itemField, ItemField::class);
    }

    public static function isPlayableItemField(?Model $playableItemField): PlayableItemField
    {
        if (is_null($playableItemField)) {
            throw new PlayableItemFieldNotFoundException();
        }

        return self::isClass($playableItemField, PlayableItemField::class);
    }

    public static function isLinkedItemField(?Model $linkedItemField): LinkedItemField
    {
        if (is_null($linkedItemField)) {
            throw new LinkedItemFieldNotFoundException();
        }

        return self::isClass($linkedItemField, LinkedItemField::class);
    }

    public static function isParameter(?Model $parameter): Parameter
    {
        if (is_null($parameter)) {
            throw new ParameterNotFoundException();
        }

        return self::isClass($parameter, Parameter::class);
    }
}
