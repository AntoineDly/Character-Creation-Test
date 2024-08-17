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
use App\Characters\Exceptions\CharacterNotFoundException;
use App\Characters\Models\Character;
use App\Games\Services\GameQueriesService;
use App\LinkedItems\Builders\LinkedItemsForCharacterDtoBuilder;
use App\LinkedItems\Dtos\LinkedItemsForCharacterDto;
use App\Shared\Builders\SharedFieldDtoBuilder\SharedFieldDtoBuilder;
use App\Shared\Enums\TypeFieldEnum;
use App\Shared\Exceptions\InvalidClassException;
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
        if (is_null($character)) {
            throw new CharacterNotFoundException(message: 'Character not found', code: 404);
        }

        if (! $character instanceof Character) {
            throw new InvalidClassException(
                'Class was expected to be Character, '.get_class($character).' given.'
            );
        }

        /** @var array{'id': string, 'name': string} $characterData */
        $characterData = $character->toArray();

        return $this->characterDtoBuilder
            ->setId(id: $characterData['id'])
            ->setName(name: $characterData['name'])
            ->build();
    }

    public function getCharacterWithGameDtoFromModel(?Model $character): CharacterWithGameDto
    {
        if (is_null($character)) {
            throw new CharacterNotFoundException(message: 'Character not found', code: 404);
        }

        if (! $character instanceof Character) {
            throw new InvalidClassException(
                'Class was expected to be Character, '.get_class($character).' given.'
            );
        }

        /** @var array{'id': string, 'name': string, 'game': array{'id': string, 'name': string}} $characterData */
        $characterData = $character->toArray();

        $gameDto = $this->gameQueriesService->getGameDtoFromArray($characterData['game']);

        return $this->characterWithGameDtoBuilder
            ->setId(id: $characterData['id'])
            ->setName(name: $characterData['name'])
            ->setGameDto(gameDto: $gameDto)
            ->build();
    }

    public function getCharacterWithLinkedItemsDtoFromModel(Character $character): CharacterWithLinkedItemsDto
    {
        if (is_null($character)) {
            throw new CharacterNotFoundException(message: 'Character not found', code: 404);
        }

        if (! $character instanceof Character) {
            throw new InvalidClassException(
                'Class was expected to be Character, '.get_class($character).' given.'
            );
        }

        /** @var array{'id': string, 'name': string, 'game': array{'id': string, 'name': string}} $characterData */
        $characterData = $character->toArray();

        $this->characterWithLinkedItemsDtoBuilder
            ->setId($characterData['id'])
            ->setName($characterData['name']);

        /**
         * @var array{string, array{'id': string, 'name': string, 'linkedItemForCharacterDtos': LinkedItemsForCharacterDto[]} $categories
         */
        $categories = [];

        foreach($characterData['game']['categories'] as $category) {
            $categories[$category['id']] = ['name' => $category['name'], 'linkedItemForCharacterDtos' => []];
        }

        foreach($characterData['linked_items'] as $linkedItem) {
            $item = $linkedItem['item'];
            $component = $item['component'];

            $this->linkedItemsForCharacterDtoBuilder
                ->setId($linkedItem['id'])
                ->setName($component['name']);

            foreach ($linkedItem['fields'] as $field) {
                $parameter = $field['parameter'];
                $sharedFieldDto = $this->sharedFieldDtoBuilder
                    ->setSharedFieldId($field['id'])
                    ->setParameterId($parameter['id'])
                    ->setName($parameter['name'])
                    ->setValue($field['value'])
                    ->setTypeParameterEnum($parameter['type'])
                    ->setTypeFieldEnum(TypeFieldEnum::FIELD)
                    ->build();
                $this->linkedItemsForCharacterDtoBuilder
                    ->addSharedFieldDto($sharedFieldDto);
            }
            foreach($item['default_item_fields'] as $defaultItemField) {
                $parameter = $defaultItemField['parameter'];
                $sharedFieldDto = $this->sharedFieldDtoBuilder
                    ->setSharedFieldId($defaultItemField['id'])
                    ->setParameterId($parameter['id'])
                    ->setName($parameter['name'])
                    ->setValue($defaultItemField['value'])
                    ->setTypeParameterEnum($parameter['type'])
                    ->setTypeFieldEnum(TypeFieldEnum::DEFAULT_ITEM_FIELD)
                    ->build();
                $this->linkedItemsForCharacterDtoBuilder
                    ->addSharedFieldDto($sharedFieldDto);
            }
            foreach($component['default_component_fields'] as $defaultComponentField) {
                $parameter = $defaultComponentField['parameter'];
                $sharedFieldDto = $this->sharedFieldDtoBuilder
                    ->setSharedFieldId($defaultComponentField['id'])
                    ->setParameterId($parameter['id'])
                    ->setName($parameter['name'])
                    ->setValue($defaultComponentField['value'])
                    ->setTypeParameterEnum($parameter['type'])
                    ->setTypeFieldEnum(TypeFieldEnum::DEFAULT_COMPONENT_FIELD)
                    ->build();
                $this->linkedItemsForCharacterDtoBuilder
                    ->addSharedFieldDto($sharedFieldDto);
            }
            $linkedItemForCharacterDto = $this->linkedItemsForCharacterDtoBuilder->build();
            $categories[$item['category']['id']]['linkedItemForCharacterDtos'][] = $linkedItemForCharacterDto;
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
