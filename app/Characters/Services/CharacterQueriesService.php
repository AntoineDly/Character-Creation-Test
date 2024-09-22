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
use App\Fields\Services\FieldQueriesService;
use App\Games\Services\GameQueriesService;
use App\Helpers\ArrayHelper;
use App\Helpers\AssertHelper;
use App\LinkedItems\Builders\LinkedItemsForCharacterDtoBuilder;
use App\LinkedItems\Dtos\LinkedItemsForCharacterDto;
use App\Shared\Enums\TypeFieldEnum;
use Illuminate\Database\Eloquent\Model;

final readonly class CharacterQueriesService
{
    public function __construct(
        private CharacterDtoBuilder $characterDtoBuilder,
        private CharacterWithGameDtoBuilder $characterWithGameDtoBuilder,
        private CharacterWithLinkedItemsDtoBuilder $characterWithLinkedItemsDtoBuilder,
        private GameQueriesService $gameQueriesService,
        private LinkedItemsForCharacterDtoBuilder $linkedItemsForCharacterDtoBuilder,
        private CategoryForCharacterDtoBuilder $categoryForCharacterDtoBuilder,
        private FieldQueriesService $fieldQueriesService,
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

        /** @var array<string, array{'name': string, 'linkedItemForCharacterDtos': LinkedItemsForCharacterDto[]}> $categories */
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

            foreach ($linkedItem->fields as $field) {
                $this->fieldQueriesService->getSharedFieldDtoFromFieldInterface(
                    $this->linkedItemsForCharacterDtoBuilder,
                    $field,
                    TypeFieldEnum::FIELD
                );
            }
            foreach ($item->defaultItemFields as $defaultItemField) {
                $this->fieldQueriesService->getSharedFieldDtoFromFieldInterface(
                    $this->linkedItemsForCharacterDtoBuilder,
                    $defaultItemField,
                    TypeFieldEnum::DEFAULT_ITEM_FIELD
                );
            }
            foreach ($component->defaultComponentFields as $defaultComponentField) {
                $this->fieldQueriesService->getSharedFieldDtoFromFieldInterface(
                    $this->linkedItemsForCharacterDtoBuilder,
                    $defaultComponentField,
                    TypeFieldEnum::DEFAULT_COMPONENT_FIELD
                );
            }
            $linkedItemForCharacterDto = $this->linkedItemsForCharacterDtoBuilder->build();
            if (array_key_exists($categoryId, $categories)) {
                $categories[$categoryId]['linkedItemForCharacterDtos'][] = $linkedItemForCharacterDto;
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
