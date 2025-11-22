<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Categories\Domain\Models\Category;
use App\Characters\Domain\Models\Character;
use App\Components\Domain\Models\Component;
use App\Games\Domain\Models\Game;
use App\Items\Domain\Models\Item;
use App\LinkedItemFields\Domain\Models\LinkedItemField;
use App\LinkedItems\Domain\Models\LinkedItem;
use App\Parameters\Domain\Enums\TypeParameterEnum;
use App\Parameters\Domain\Models\Parameter;
use App\PlayableItems\Domain\Models\PlayableItem;

it('get character with linked items with valid game uuid should return 200 with the character', function () {
    $category = Category::factory()->create(['user_id' => $this->getUserId()]);
    $component = Component::factory()->create(['user_id' => $this->getUserId()]);
    $item = Item::factory()->create([
        'category_id' => $category->id,
        'component_id' => $component->id,
        'user_id' => $this->getUserId(),
    ]);
    $game = Game::factory()->create(['user_id' => $this->getUserId()]);
    $game->categories()->save($category);
    $playableItem = PlayableItem::factory()->create([
        'item_id' => $item->id,
        'game_id' => $game->id,
        'user_id' => $this->getUserId(),
    ]);
    $character = Character::factory()->create(['game_id' => $game->id, 'user_id' => $this->getUserId()]);
    $linkedItem = LinkedItem::factory()->create(['character_id' => $character->id, 'playable_item_id' => $playableItem->id, 'user_id' => $this->getUserId()]);
    $parameter = Parameter::factory()->create(['type' => TypeParameterEnum::STRING, 'user_id' => $this->getUserId()]);
    $fieldData = [
        'value' => 'test',
        'parameter_id' => $parameter->id,
        'linked_item_id' => $linkedItem->id,
        'user_id' => $this->getUserId(),
    ];

    $field = LinkedItemField::factory()->create($fieldData);

    $response = $this->getJson('/api/characters/'.$character->id.'/with_linked_items');
    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
                'gameDto' => [
                    'id',
                    'name',
                ],
                'categoryForCharacterDtoCollection' => [
                    [
                        'id',
                        'name',
                        'linkedItemForCharacterDtoCollection' => [
                            [
                                'id',
                                'fieldDtoCollection' => [
                                    $parameter->name => [
                                        'id',
                                        'parameterId',
                                        'name',
                                        'value',
                                        'typeParameterEnum',
                                        'typeFieldEnum',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ])
        ->assertJson([
            'success' => true,
            'message' => 'Character was successfully retrieved.',
            'data' => [
                'id' => $character->id,
                'gameDto' => [
                    'id' => $game->id,
                    'name' => $game->name,
                ],
                'categoryForCharacterDtoCollection' => [
                    [
                        'id' => $category->id,
                        'name' => $category->name,
                        'linkedItemForCharacterDtoCollection' => [
                            [
                                'id' => $linkedItem->id,
                                'fieldDtoCollection' => [
                                    $parameter->name => [
                                        'id' => $field->id,
                                        'parameterId' => $parameter->id,
                                        'name' => $parameter->name,
                                        'value' => $field->getValue(),
                                        'typeParameterEnum' => $parameter->type->value,
                                        'typeFieldEnum' => $field->getType()->value,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
});

it('get character with linked items with invalid character uuid should return 404 with the character not found.', function () {
    $response = $this->getJson('/api/characters/invalid-uuid/with_linked_items');

    $response->assertStatus(404)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => false,
            'message' => 'Character not found.',
        ]);
});
