<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Categories\Models\Category;
use App\Characters\Models\Character;
use App\Components\Models\Component;
use App\Games\Models\Game;
use App\Items\Models\Item;
use App\LinkedItems\Models\LinkedItem;
use App\Parameters\Enums\TypeParameterEnum;
use App\Parameters\Models\Parameter;

it('create field should return 201 with a new field created', function () {
    $category = Category::factory()->create(['user_id' => $this->getUserId()]);
    $component = Component::factory()->create(['user_id' => $this->getUserId()]);
    $item = Item::factory()->create([
        'category_id' => $category->id,
        'component_id' => $component->id,
        'user_id' => $this->getUserId(),
    ]);
    $game = Game::factory()->create(['user_id' => $this->getUserId()]);
    $character = Character::factory()->create(['game_id' => $game->id, 'user_id' => $this->getUserId()]);
    $linkedItem = LinkedItem::factory()->create(['character_id' => $character->id, 'item_id' => $item->id, 'user_id' => $this->getUserId()]);
    $parameter = Parameter::factory()->create(['type' => TypeParameterEnum::STRING, 'user_id' => $this->getUserId()]);

    $fieldData = ['value' => 'string', 'parameterId' => $parameter->id, 'linkedItemId' => $linkedItem->id];
    $fieldExpectedResult = ['value' => 'string', 'parameterId' => 'parameterId', 'linkedItemId' => 'linkedItemId', 'userId' => 'userId'];
    $this->assertDatabaseMissing('fields', $fieldExpectedResult);

    $response = $this->postJson('/api/fields', $fieldData);
    $response->assertStatus(201)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => true,
            'message' => 'Field was successfully created.',
        ]);

    $this->assertDatabaseHas('fields', $fieldExpectedResult);
});

it('create fields should return 422 with value not being a string and parameter and item not being parameter or item', function () {
    $fieldData = ['value' => 123, 'parameterId' => 'invalid-parameter-id', 'linkedItemId' => 'invalid-linked-item-id'];
    $fieldExpectedResult = [...$fieldData, 'userId' => 'userId'];
    $this->assertDatabaseMissing('fields', $fieldExpectedResult);

    $response = $this->postJson('/api/fields', $fieldData);
    $response->assertStatus(422)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'value',
                'parameterId',
                'linkedItemId',
            ],
        ])
        ->assertJson([
            'success' => false,
            'message' => 'Field was not successfully created.',
            'data' => [
                'value' => [
                    'The value field must be a string.',
                ],
                'linkedItemId' => [
                    'No linked item found for this linkedItemId.',
                ],
                'parameterId' => [
                    'No parameter found for this parameterId.',
                ],
            ],
        ]);

    $this->assertDatabaseMissing('fields', $fieldExpectedResult);
});
