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
use App\Fields\Exceptions\FieldInterfaceNotFoundException;
use App\Fields\Exceptions\FieldNotFoundException;
use App\Fields\Models\Field;
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

    public static function isDefaultItemField(?Model $defaultItemField): DefaultItemField
    {
        if (is_null($defaultItemField)) {
            throw new DefaultItemFieldNotFoundException();
        }

        if (! $defaultItemField instanceof DefaultItemField) {
            throw new InvalidClassException(data: ['expectedClass' => DefaultItemField::class, 'currentClass' => $defaultItemField::class]);
        }

        return $defaultItemField;
    }

    public static function isDefaultComponentField(?Model $defaultComponentField): DefaultComponentField
    {
        if (is_null($defaultComponentField)) {
            throw new DefaultComponentFieldNotFoundException();
        }

        if (! $defaultComponentField instanceof DefaultComponentField) {
            throw new InvalidClassException(data: ['expectedClass' => DefaultComponentField::class, 'currentClass' => $defaultComponentField::class]);
        }

        return $defaultComponentField;
    }

    public static function isField(?Model $field): Field
    {
        if (is_null($field)) {
            throw new FieldNotFoundException();
        }

        if (! $field instanceof Field) {
            throw new InvalidClassException(data: ['expectedClass' => Field::class, 'currentClass' => $field::class]);
        }

        return $field;
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
