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
use App\Characters\Models\Character;
use App\Components\Exceptions\ComponentNotFoundException;
use App\Games\Exceptions\GameNotFoundException;
use App\Games\Services\GameQueriesService;
use App\Helpers\ArrayHelper;
use App\Helpers\AssertHelper;
use App\Items\Exceptions\ItemNotFoundException;
use App\LinkedItems\Builders\LinkedItemForCharacterDtoBuilder;
use App\LinkedItems\Dtos\LinkedItemForCharacterDto;
use App\LinkedItems\Exceptions\LinkedItemNotFoundException;
use App\Shared\Fields\Services\FieldServices;
use App\Shared\Http\Exceptions\InvalidClassException;
use App\Shared\Http\Exceptions\NotAValidUuidException;
use App\Shared\Http\Exceptions\StringIsEmptyException;
use Illuminate\Database\Eloquent\Model;

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
    public function getCharacterWithLinkedItemsDtoFromModel(Character $character): CharacterWithLinkedItemsDto
    {
        $game = AssertHelper::isGame($character->game);

        $gameDto = $this->gameQueriesService->getGameDtoFromModel($character->game);

        $this->characterWithLinkedItemsDtoBuilder
            ->setId($character->id)
            ->setGameDto($gameDto);

        /** @var array<string, array{'name': string, 'linkedItemForCharacterDtos': LinkedItemForCharacterDto[]}> $categories */
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
            $playableItem = AssertHelper::isPlayableItem($linkedItem->playableItem);
            $item = AssertHelper::isItem($playableItem->item);
            $component = AssertHelper::isComponent($item->component);
            $category = AssertHelper::isCategory($item->category);
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
