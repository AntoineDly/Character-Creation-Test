<?php

declare(strict_types=1);

namespace App\Characters\Domain\Services;

use App\Categories\Domain\Dtos\CategoryForCharacterDto\CategoryForCharacterDtoBuilder;
use App\Categories\Infrastructure\Exceptions\CategoryNotFoundException;
use App\Characters\Domain\Dtos\CharacterDto\CharacterDto;
use App\Characters\Domain\Dtos\CharacterDto\CharacterDtoBuilder;
use App\Characters\Domain\Dtos\CharacterWithGameDto\CharacterWithGameDto;
use App\Characters\Domain\Dtos\CharacterWithGameDto\CharacterWithGameDtoBuilder;
use App\Characters\Domain\Dtos\CharacterWithLinkedItemsDto\CharacterWithLinkedItemsDto;
use App\Characters\Domain\Dtos\CharacterWithLinkedItemsDto\CharacterWithLinkedItemsDtoBuilder;
use App\Characters\Domain\Models\Character;
use App\Fields\Services\FieldServices;
use App\Games\Domain\Services\GameQueriesService;
use App\Helpers\ArrayHelper;
use App\Helpers\AssertHelper;
use App\LinkedItems\Domain\Dtos\LinkedItemForCharacterDto\LinkedItemForCharacterDto;
use App\LinkedItems\Domain\Dtos\LinkedItemForCharacterDto\LinkedItemForCharacterDtoBuilder;

final readonly class CharacterQueriesService
{
    public function __construct(
        private CharacterDtoBuilder $characterDtoBuilder,
        private CharacterWithGameDtoBuilder $characterWithGameDtoBuilder,
        private CharacterWithLinkedItemsDtoBuilder $characterWithLinkedItemsDtoBuilder,
        private GameQueriesService $gameQueriesService,
        private LinkedItemForCharacterDtoBuilder $linkedItemsForCharacterDtoBuilder,
        private CategoryForCharacterDtoBuilder $categoryForCharacterDtoBuilder,
        private FieldServices $fieldServices,
    ) {
    }

    public function getCharacterDtoFromModel(?Character $character): CharacterDto
    {
        $character = AssertHelper::isCharacterNotNull($character);

        return $this->characterDtoBuilder
            ->setId(id: $character->id)
            ->build();
    }

    public function getCharacterWithGameDtoFromModel(?Character $character): CharacterWithGameDto
    {
        $character = AssertHelper::isCharacterNotNull($character);

        $gameDto = $this->gameQueriesService->getGameDtoFromModel($character->game);

        return $this->characterWithGameDtoBuilder
            ->setId(id: $character->id)
            ->setGameDto(gameDto: $gameDto)
            ->build();
    }

    public function getCharacterWithLinkedItemsDtoFromModel(Character $character): CharacterWithLinkedItemsDto
    {
        $game = AssertHelper::isGameNotNull($character->game);

        $gameDto = $this->gameQueriesService->getGameDtoFromModel($character->game);

        $this->characterWithLinkedItemsDtoBuilder
            ->setId($character->id)
            ->setGameDto($gameDto);

        /** @var array<string, array{'name': string, 'linkedItemForCharacterDtos': LinkedItemForCharacterDto[]}> $categories */
        $categories = [];

        foreach ($game->categories as $category) {
            $category = AssertHelper::isCategoryNotNull($category);
            $categories[$category->id] = ['name' => $category->name, 'linkedItemForCharacterDtos' => []];
        }

        if (ArrayHelper::isEmpty($categories)) {
            return $this->characterWithLinkedItemsDtoBuilder->build();
        }

        foreach ($character->linkedItems as $linkedItem) {
            $linkedItem = AssertHelper::isLinkedItemNotNull($linkedItem);
            $playableItem = AssertHelper::isPlayableItemNotNull($linkedItem->playableItem);
            $item = AssertHelper::isItemNotNull($playableItem->item);
            $component = AssertHelper::isComponentNotNull($item->component);
            $category = AssertHelper::isCategoryNotNull($item->category);
            $categoryId = $category->id;

            $fieldDtoCollection = $this->fieldServices->getFieldDtoCollectionFromFieldInterfaces([
                ...$linkedItem->linkedItemFields,
                ...$playableItem->playableItemFields,
                ...$item->itemFields,
                ...$component->componentFields,
            ]);

            $linkedItemForCharacterDto = $this->linkedItemsForCharacterDtoBuilder
                ->setId($linkedItem->id)
                ->setFieldDtoCollection($fieldDtoCollection)
                ->build();

            if (! array_key_exists($categoryId, $categories)) {
                throw new CategoryNotFoundException(message: 'Category not found inside game.');
            }
            $categories[$categoryId]['linkedItemForCharacterDtos'][] = $linkedItemForCharacterDto;
        }

        foreach ($categories as $categoryId => $categoryData) {
            $categoryForCharacterDto = $this->categoryForCharacterDtoBuilder
                ->setId($categoryId)
                ->setName($categoryData['name'])
                ->setLinkedItemForCharacterDtos($categoryData['linkedItemForCharacterDtos'])
                ->build();
            $this->characterWithLinkedItemsDtoBuilder->addCategoryForCharacterDto($categoryForCharacterDto);
        }

        return $this->characterWithLinkedItemsDtoBuilder->build();
    }
}
