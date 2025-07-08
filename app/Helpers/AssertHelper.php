<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Categories\Models\Category;
use App\Characters\Models\Character;
use App\ComponentFields\Models\ComponentField;
use App\Components\Models\Component;
use App\Games\Models\Game;
use App\ItemFields\Models\ItemField;
use App\Items\Models\Item;
use App\LinkedItemFields\Models\LinkedItemField;
use App\LinkedItems\Models\LinkedItem;
use App\Parameters\Models\Parameter;
use App\PlayableItemFields\Models\PlayableItemField;
use App\PlayableItems\Models\PlayableItem;
use App\Shared\Fields\Interfaces\FieldInterface;
use App\Shared\Http\Exceptions\ElementNotFoundException;
use App\Shared\Http\Exceptions\InvalidClassException;

abstract readonly class AssertHelper
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

    /**
     * @template T
     *
     * @param  T|null  $element
     * @return T
     */
    public static function isNotNull($element, string $type = 'element')
    {
        if (is_null($element)) {
            throw new ElementNotFoundException(message: "{$type} not found.");
        }

        /** @var T $element */
        return $element;
    }

    public static function isCharacterNotNull(?Character $character): Character
    {
        return AssertHelper::isNotNull($character, ClassHelper::getShortname(Character::class));
    }

    public static function isGameNotNull(?Game $game): Game
    {
        return AssertHelper::isNotNull($game, ClassHelper::getShortname(Game::class));
    }

    public static function isCategoryNotNull(?Category $category): Category
    {
        return AssertHelper::isNotNull($category, ClassHelper::getShortname(Category::class));
    }

    public static function isComponentNotNull(?Component $component): Component
    {
        return AssertHelper::isNotNull($component, ClassHelper::getShortname(Component::class));
    }

    public static function isItemNotNull(?Item $item): Item
    {
        return AssertHelper::isNotNull($item, ClassHelper::getShortname(Item::class));
    }

    public static function isPlayableItemNotNull(?PlayableItem $playableItem): PlayableItem
    {
        return AssertHelper::isNotNull($playableItem, ClassHelper::getShortname(PlayableItem::class));
    }

    public static function isLinkedItemNotNull(?LinkedItem $linkedItem): LinkedItem
    {
        return AssertHelper::isNotNull($linkedItem, ClassHelper::getShortname(LinkedItem::class));
    }

    public static function isFieldInterfaceNotNull(?FieldInterface $fieldInterface): FieldInterface
    {
        return AssertHelper::isNotNull($fieldInterface, ClassHelper::getShortname(FieldInterface::class));
    }

    public static function isComponentFieldNotNull(?ComponentField $componentField): ComponentField
    {
        return AssertHelper::isNotNull($componentField, ClassHelper::getShortname(ComponentField::class));
    }

    public static function isItemFieldNotNull(?ItemField $itemField): ItemField
    {
        return AssertHelper::isNotNull($itemField, ClassHelper::getShortname(ItemField::class));
    }

    public static function isPlayableItemFieldNotNull(?PlayableItemField $playableItemField): PlayableItemField
    {
        return AssertHelper::isNotNull($playableItemField, ClassHelper::getShortname(PlayableItemField::class));
    }

    public static function isLinkedItemFieldNotNull(?LinkedItemField $linkedItemField): LinkedItemField
    {
        return AssertHelper::isNotNull($linkedItemField, ClassHelper::getShortname(LinkedItemField::class));
    }

    public static function isParameterNotNull(?Parameter $parameter): Parameter
    {
        return AssertHelper::isNotNull($parameter, ClassHelper::getShortname(Parameter::class));
    }
}
