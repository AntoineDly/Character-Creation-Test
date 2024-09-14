<?php

declare(strict_types=1);

namespace App\Characters\Services;

use App\Categories\Builders\CategoryForCharacterDtoBuilder;
use App\Characters\Builders\CharacterDtoBuilder;
use App\Characters\Builders\CharacterWithGameDtoBuilder;
use App\Characters\Builders\CharacterWithLinkedItemsDtoBuilder;
use App\Characters\Dtos\CharacterDto;
use App\Characters\Dtos\CharacterWithGameDto;
use App\Characters\Dtos\CharacterWithLinkedItemsDto;
use App\Games\Services\GameQueriesService;
use App\Helpers\ArrayHelper;
use App\Helpers\AssertHelper;
use App\LinkedItems\Builders\LinkedItemsForCharacterDtoBuilder;
use App\LinkedItems\Dtos\LinkedItemsForCharacterDto;
use App\Shared\Builders\SharedFieldDtoBuilder\SharedFieldDtoBuilder;
use App\Shared\Enums\TypeFieldEnum;
use Illuminate\Database\Eloquent\Model;

final readonly class CharacterQueriesService
{
    public function __construct(
        private CharacterDtoBuilder $characterDtoBuilder,
        private CharacterWithGameDtoBuilder $characterWithGameDtoBuilder,
        private CharacterWithLinkedItemsDtoBuilder $characterWithLinkedItemsDtoBuilder,
        private GameQueriesService $gameQueriesService,
        private SharedFieldDtoBuilder $sharedFieldDtoBuilder,
        private LinkedItemsForCharacterDtoBuilder $linkedItemsForCharacterDtoBuilder,
        private CategoryForCharacterDtoBuilder $categoryForCharacterDtoBuilder,
    ) {
    }

    public function getCharacterDtoFromModel(?Model $character): CharacterDto
    {
        $character = AssertHelper::isCharacter($character);

        return $this->characterDtoBuilder
            ->setId(id: $character->id)
            ->setName(name: $character->name)
            ->build();
    }

    public function getCharacterWithGameDtoFromModel(?Model $character): CharacterWithGameDto
    {
        $character = AssertHelper::isCharacter($character);

        $gameDto = $this->gameQueriesService->getGameDtoFromModel($character->game);

        return $this->characterWithGameDtoBuilder
            ->setId(id: $character->id)
            ->setName(name: $character->name)
            ->setGameDto(gameDto: $gameDto)
            ->build();
    }

    public function getCharacterWithLinkedItemsDtoFromModel(?Model $character): CharacterWithLinkedItemsDto
    {
        $character = AssertHelper::isCharacter($character);
        $game = AssertHelper::isGame($character->game);

        $this->characterWithLinkedItemsDtoBuilder
            ->setId($character->id)
            ->setName($character->name);

        /** @var array{'id': string, 'name': string, 'linkedItemForCharacterDtos': LinkedItemsForCharacterDto[]} $categories */
        $categories = [];

        foreach ($game->categories as $category) {
            $category = AssertHelper::isCategory($category);
            $categories[$category->id] = ['name' => $category->name, 'linkedItemForCharacterDtos' => []];
        }

        if (ArrayHelper::isEmpty($categories)) {
            return $this->characterWithLinkedItemsDtoBuilder->build();
        }

        foreach ($character->linkedItems as $linkedItem) {
            $linkedItem = AssertHelper::isLinkedItem($linkedItem);
            $item = AssertHelper::isItem($linkedItem->item);
            $component = AssertHelper::isComponent($item->component);
            $category = AssertHelper::isCategory($item->category);
            $categoryId = $category->id;

            $this->linkedItemsForCharacterDtoBuilder
                ->setId($linkedItem->id)
                ->setName($component->name);

            //@todo refacto all of them with a FieldInterface having getId, getName, getValue and getParameter methods
            foreach ($linkedItem->fields as $field) {
                $field = AssertHelper::isField($field);
                $parameter = AssertHelper::isParameter($field->parameter);
                $sharedFieldDto = $this->sharedFieldDtoBuilder
                    ->setId($field->id)
                    ->setParameterId($parameter->id)
                    ->setName($parameter->name)
                    ->setValue($field->value)
                    ->setTypeParameterEnum($parameter->type)
                    ->setTypeFieldEnum(TypeFieldEnum::FIELD)
                    ->build();
                $this->linkedItemsForCharacterDtoBuilder
                    ->addSharedFieldDto($sharedFieldDto);
            }
            foreach ($item->defaultItemFields as $defaultItemField) {
                $defaultItemField = AssertHelper::isDefaultItemField($defaultItemField);
                $parameter = AssertHelper::isParameter($defaultItemField->parameter);
                $sharedFieldDto = $this->sharedFieldDtoBuilder
                    ->setId($defaultItemField->id)
                    ->setParameterId($parameter->id)
                    ->setName($parameter->name)
                    ->setValue($defaultItemField->value)
                    ->setTypeParameterEnum($parameter->type)
                    ->setTypeFieldEnum(TypeFieldEnum::DEFAULT_ITEM_FIELD)
                    ->build();
                $this->linkedItemsForCharacterDtoBuilder
                    ->addSharedFieldDto($sharedFieldDto);
            }
            foreach ($component->defaultComponentFields as $defaultComponentField) {
                $defaultComponentField = AssertHelper::isDefaultComponentField($defaultComponentField);
                $parameter = AssertHelper::isParameter($defaultComponentField->parameter);
                $sharedFieldDto = $this->sharedFieldDtoBuilder
                    ->setId($defaultComponentField->id)
                    ->setParameterId($parameter->id)
                    ->setName($parameter->name)
                    ->setValue($defaultComponentField->value)
                    ->setTypeParameterEnum($parameter->type)
                    ->setTypeFieldEnum(TypeFieldEnum::DEFAULT_COMPONENT_FIELD)
                    ->build();
                $this->linkedItemsForCharacterDtoBuilder
                    ->addSharedFieldDto($sharedFieldDto);
            }
            $linkedItemForCharacterDto = $this->linkedItemsForCharacterDtoBuilder->build();
            if (array_key_exists($categoryId, $categories)) {
                array_push($categories[$categoryId]['linkedItemForCharacterDtos'], $linkedItemForCharacterDto);
            }
        }

        foreach ($categories as $categoryId => $categoryData) {
            $categoryForCharacterDto = $this->categoryForCharacterDtoBuilder
                ->setId($categoryId)
                ->setName($categoryData['name'])
                ->setLinkedItemsForCharacterDtos($categoryData['linkedItemForCharacterDtos'])
                ->build();
            $this->characterWithLinkedItemsDtoBuilder->addCategoryForCharacterDto($categoryForCharacterDto);
        }

        return $this->characterWithLinkedItemsDtoBuilder->build();
    }
}
