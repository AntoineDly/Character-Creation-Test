<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Categories\Domain\Models\Category;
use App\Components\Domain\Models\Component;
use App\Games\Domain\Models\Game;
use App\Items\Domain\Models\Item;
use App\Parameters\Domain\Enums\TypeParameterEnum;
use App\Parameters\Domain\Models\Parameter;
use App\PlayableItems\Domain\Models\PlayableItem;

it('create playable item field should return 201 with a new field created', function () {
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
    $parameter = Parameter::factory()->create(['type' => TypeParameterEnum::STRING, 'user_id' => $this->getUserId()]);

    $fieldData = ['value' => 'string', 'parameterId' => $parameter->id, 'playableItemId' => $playableItem->id];
    $fieldExpectedResult = ['value' => 'string', 'parameter_id' => $parameter->id, 'playable_item_id' => $playableItem->id, 'user_id' => $this->getUserId()];
    $this->assertDatabaseMissing('playable_item_fields', $fieldExpectedResult);

    $response = $this->postJson('/api/playable_item_fields', $fieldData);
    $response->assertStatus(201)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => true,
            'message' => 'PlayableItem Field was successfully created.',
        ]);

    $this->assertDatabaseHas('playable_item_fields', $fieldExpectedResult);
});

it('create fields should return 422 with value not being a string and parameter and item not being parameter or item', function () {
    $fieldData = ['value' => 123, 'parameterId' => 'invalid-parameter-id', 'playableItemId' => 'invalid-playable-item-id'];
    $fieldExpectedResult = ['value' => 123, 'parameter_id' => 'invalid-parameter-id', 'playable_item_id' => 'invalid-playable-item-id', 'user_id' => $this->getUserId()];
    $this->assertDatabaseMissing('playable_item_fields', $fieldExpectedResult);

    $response = $this->postJson('/api/playable_item_fields', $fieldData);
    $response->assertStatus(422)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'value',
                'parameterId',
                'playableItemId',
            ],
        ])
        ->assertJson([
            'success' => false,
            'message' => 'PlayableItem Field was not successfully created.',
            'data' => [
                'value' => [
                    'The value field must be a string.',
                ],
                'playableItemId' => [
                    'No playable item found for this playableItemId.',
                ],
                'parameterId' => [
                    'No parameter found for this parameterId.',
                ],
            ],
        ]);

    $this->assertDatabaseMissing('playable_item_fields', $fieldExpectedResult);
});
