<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Categories\Models\Category;
use App\Characters\Models\Character;
use App\Components\Models\Component;
use App\Games\Models\Game;
use App\Items\Models\Item;
use App\LinkedItemFields\Models\LinkedItemField;
use App\LinkedItems\Models\LinkedItem;
use App\Parameters\Enums\TypeParameterEnum;
use App\Parameters\Models\Parameter;
use App\PlayableItems\Models\PlayableItem;

it('get linked item fields should return 200 without any fields', function () {
    $response = $this->getJson('/api/linked_item_fields');
    $response->assertStatus(200)
        ->assertJsonStructure(['success', 'message', 'data'])
        ->assertJson([
            'success' => true,
            'message' => 'Linked Item Fields were successfully retrieved.',
            'data' => [],
        ]);
});

it('get linked item fields should return 200 with fields', function () {
    $category = Category::factory()->create(['user_id' => $this->getUserId()]);
    $component = Component::factory()->create(['user_id' => $this->getUserId()]);
    $item = Item::factory()->create([
        'category_id' => $category->id,
        'component_id' => $component->id,
        'user_id' => $this->getUserId(),
    ]);
    $game = Game::factory()->create(['user_id' => $this->getUserId()]);
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

    $response = $this->getJson('/api/linked_item_fields');
    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                [
                    'id',
                    'value',
                ],
            ],
        ])
        ->assertJson([
            'success' => true,
            'message' => 'Linked Item Fields were successfully retrieved.',
            'data' => [
                [
                    'id' => $field->id,
                    'value' => $field->value,
                ],
            ],
        ]);
});

it('get linked item field with valid field uuid should return 200 with the field', function () {
    $category = Category::factory()->create(['user_id' => $this->getUserId()]);
    $component = Component::factory()->create(['user_id' => $this->getUserId()]);
    $item = Item::factory()->create([
        'category_id' => $category->id,
        'component_id' => $component->id,
        'user_id' => $this->getUserId(),
    ]);
    $game = Game::factory()->create(['user_id' => $this->getUserId()]);
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

    $response = $this->getJson('/api/linked_item_fields/'.$field->id);
    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
                'value',
            ],
        ])
        ->assertJson([
            'success' => true,
            'message' => 'Linked Item Field was successfully retrieved.',
            'data' => [
                'id' => $field->id,
                'value' => $field->value,
            ],
        ]);
});

it('get linked item field with invalid field uuid should return 404 with the linked item field not found.', function () {
    $response = $this->getJson('/api/linked_item_fields/invalid-uuid');
    $response->assertStatus(404)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => false,
            'message' => 'Linked Item Field not found.',
        ]);
});
