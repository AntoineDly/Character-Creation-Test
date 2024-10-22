<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Categories\Exceptions\CategoryNotFoundException;
use App\Categories\Models\Category;
use App\Characters\Exceptions\CharacterNotFoundException;
use App\Characters\Models\Character;
use App\Components\Exceptions\ComponentNotFoundException;
use App\Components\Models\Component;
use App\DefaultComponentFields\Exceptions\DefaultComponentFieldNotFoundException;
use App\DefaultComponentFields\Models\DefaultComponentField;
use App\DefaultItemFields\Exceptions\DefaultItemFieldNotFoundException;
use App\DefaultItemFields\Models\DefaultItemField;
use App\Fields\Exceptions\FieldNotFoundException;
use App\Fields\Models\FieldInterface;
use App\Games\Exceptions\GameNotFoundException;
use App\Games\Models\Game;
use App\Items\Exceptions\ItemNotFoundException;
use App\Items\Models\Item;
use App\LinkedItems\Exceptions\LinkedItemNotFoundException;
use App\LinkedItems\Models\LinkedItem;
use App\Parameters\Exceptions\ParameterNotFoundException;
use App\Parameters\Models\Parameter;
use App\Shared\Exceptions\Http\InvalidClassException;
use Illuminate\Database\Eloquent\Model;

final readonly class AssertHelper
{
    public static function isCharacter(?Model $character): Character
    {
        if (is_null($character)) {
            throw new CharacterNotFoundException(message: 'Character not found');
        }

        if (! $character instanceof Character) {
            throw new InvalidClassException(
                'Class was expected to be Character, '.get_class($character).' given.'
            );
        }

        return $character;
    }

    public static function isGame(?Model $game): Game
    {
        if (is_null($game)) {
            throw new GameNotFoundException(message: 'Game not found');
        }

        if (! $game instanceof Game) {
            throw new InvalidClassException(
                'Class was expected to be Game, '.get_class($game).' given.'
            );
        }

        return $game;
    }

    public static function isCategory(?Model $category): Category
    {
        if (is_null($category)) {
            throw new CategoryNotFoundException(message: 'Category not found');
        }

        if (! $category instanceof Category) {
            throw new InvalidClassException(
                'Class was expected to be Category, '.get_class($category).' given.'
            );
        }

        return $category;
    }

    public static function isLinkedItem(?Model $linkedItem): LinkedItem
    {
        if (is_null($linkedItem)) {
            throw new LinkedItemNotFoundException(message: 'LinkedItem not found');
        }

        if (! $linkedItem instanceof LinkedItem) {
            throw new InvalidClassException(
                'Class was expected to be LinkedItem, '.get_class($linkedItem).' given.'
            );
        }

        return $linkedItem;
    }

    public static function isItem(?Model $item): Item
    {
        if (is_null($item)) {
            throw new ItemNotFoundException(message: 'Item not found');
        }

        if (! $item instanceof Item) {
            throw new InvalidClassException(
                'Class was expected to be Item, '.get_class($item).' given.'
            );
        }

        return $item;
    }

    public static function isComponent(?Model $component): Component
    {
        if (is_null($component)) {
            throw new ComponentNotFoundException(message: 'Component not found');
        }

        if (! $component instanceof Component) {
            throw new InvalidClassException(
                'Class was expected to be Component, '.get_class($component).' given.'
            );
        }

        return $component;
    }

    public static function isField(?Model $field): FieldInterface
    {
        if (is_null($field)) {
            throw new FieldNotFoundException(message: 'Field not found');
        }

        if (! $field instanceof FieldInterface) {
            throw new InvalidClassException(
                'Class was expected to be Field, '.get_class($field).' given.'
            );
        }

        return $field;
    }

    public static function isDefaultItemField(?Model $defaultItemField): DefaultItemField
    {
        if (is_null($defaultItemField)) {
            throw new DefaultItemFieldNotFoundException(message: 'DefaultItemField not found');
        }

        if (! $defaultItemField instanceof DefaultItemField) {
            throw new InvalidClassException(
                'Class was expected to be DefaultItemField, '.get_class($defaultItemField).' given.'
            );
        }

        return $defaultItemField;
    }

    public static function isDefaultComponentField(?Model $defaultComponentField): DefaultComponentField
    {
        if (is_null($defaultComponentField)) {
            throw new DefaultComponentFieldNotFoundException(message: 'DefaultComponentField not found');
        }

        if (! $defaultComponentField instanceof DefaultComponentField) {
            throw new InvalidClassException(
                'Class was expected to be DefaultComponentField, '.get_class($defaultComponentField).' given.'
            );
        }

        return $defaultComponentField;
    }

    public static function isParameter(?Model $parameter): Parameter
    {
        if (is_null($parameter)) {
            throw new ParameterNotFoundException(message: 'Parameter not found');
        }

        if (! $parameter instanceof Parameter) {
            throw new InvalidClassException(
                'Class was expected to be Parameter, '.get_class($parameter).' given.'
            );
        }

        return $parameter;
    }
}
