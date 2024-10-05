<?php

declare(strict_types=1);

namespace App\Characters\Services;

use App\Categories\Builders\CategoryForCharacterDtoBuilder;
use App\Categories\Exceptions\CategoryNotFoundException;
use App\Characters\Builders\CharacterDtoBuilder;
use App\Characters\Builders\CharacterWithGameDtoBuilder;
use App\Characters\Builders\CharacterWithLinkedItemsDtoBuilder;
use App\Characters\Dtos\CharacterDto;
use App\Characters\Dtos\CharacterWithGameDto;
use App\Characters\Dtos\CharacterWithLinkedItemsDto;
use App\Characters\Exceptions\CharacterNotFoundException;
use App\Components\Exceptions\ComponentNotFoundException;
use App\Fields\Services\FieldQueriesService;
use App\Games\Exceptions\GameNotFoundException;
use App\Games\Services\GameQueriesService;
use App\Helpers\ArrayHelper;
use App\Helpers\AssertHelper;
use App\Items\Exceptions\ItemNotFoundException;
use App\LinkedItems\Builders\LinkedItemsForCharacterDtoBuilder;
use App\LinkedItems\Dtos\LinkedItemsForCharacterDto;
use App\LinkedItems\Exceptions\LinkedItemNotFoundException;
use App\Shared\Enums\TypeFieldEnum;
use App\Shared\Exceptions\InvalidClassException;
use App\Shared\Exceptions\NotAValidUuidException;
use App\Shared\Exceptions\StringIsEmptyException;
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

    /**
     * @throws CharacterNotFoundException
     * @throws NotAValidUuidException
     * @throws InvalidClassException
     */
    public function getCharacterDtoFromModel(?Model $character): CharacterDto
    {
        $character = AssertHelper::isCharacter($character);

        return $this->characterDtoBuilder
            ->setId(id: $character->id)
            ->build();
    }

    /**
     * @throws CharacterNotFoundException
     * @throws GameNotFoundException
     * @throws NotAValidUuidException
     * @throws InvalidClassException
     */
    public function getCharacterWithGameDtoFromModel(?Model $character): CharacterWithGameDto
    {
        $character = AssertHelper::isCharacter($character);

        $gameDto = $this->gameQueriesService->getGameDtoFromModel($character->game);

        return $this->characterWithGameDtoBuilder
            ->setId(id: $character->id)
            ->setGameDto(gameDto: $gameDto)
            ->build();
    }

    /**
     * @throws LinkedItemNotFoundException
     * @throws CharacterNotFoundException
     * @throws ComponentNotFoundException
     * @throws ItemNotFoundException
     * @throws CategoryNotFoundException
     * @throws GameNotFoundException
     * @throws InvalidClassException
     * @throws StringIsEmptyException
     * @throws NotAValidUuidException
     */
    public function getCharacterWithLinkedItemsDtoFromModel(?Model $character): CharacterWithLinkedItemsDto
    {
        $character = AssertHelper::isCharacter($character);
        $game = AssertHelper::isGame($character->game);

        $gameDto = $this->gameQueriesService->getGameDtoFromModel($character->game);

        $this->characterWithLinkedItemsDtoBuilder
            ->setId($character->id)
            ->setGameDto($gameDto);

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
                ->setId($linkedItem->id);

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
