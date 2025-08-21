<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Categories\Domain\Models\Category;
use App\Characters\Domain\Models\Character;
use App\Components\Domain\Models\Component;
use App\Games\Domain\Models\Game;
use App\Items\Domain\Models\Item;
use App\LinkedItems\Domain\Models\LinkedItem;
use App\Parameters\Domain\Enums\TypeParameterEnum;
use App\Parameters\Domain\Models\Parameter;
use App\PlayableItems\Domain\Models\PlayableItem;

it('create field should return 201 with a new field created', function () {
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
