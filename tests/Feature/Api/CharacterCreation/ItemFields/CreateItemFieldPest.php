<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Categories\Models\Category;
use App\Components\Models\Component;
use App\Items\Models\Item;
use App\Parameters\Enums\TypeParameterEnum;
use App\Parameters\Models\Parameter;

it('create itemField should return 201 with a new itemField created', function () {
    $category = Category::factory()->create(['user_id' => $this->getUserId()]);
    $component = Component::factory()->create(['user_id' => $this->getUserId()]);
    $item = Item::factory()->create([
        'category_id' => $category->id,
        'component_id' => $component->id,
        'user_id' => $this->getUserId(),
    ]);
    $parameter = Parameter::factory()->create(['type' => TypeParameterEnum::STRING, 'user_id' => $this->getUserId()]);

    $itemFieldData = ['value' => 'string', 'parameterId' => $parameter->id, 'itemId' => $item->id];
    $itemFieldExpectedResult = ['value' => 'string', 'parameterId' => 'parameterId', 'itemId' => 'itemId', 'userId' => 'userId'];
    $this->assertDatabaseMissing('item_fields', $itemFieldExpectedResult);

    $response = $this->postJson('/api/item_fields', $itemFieldData);
    $response->assertStatus(201)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => true,
            'message' => 'ItemFieldas successfully created.',
        ]);

    $this->assertDatabaseHas('item_fields', $itemFieldExpectedResult);
});

it('create itemFields should return 422 with value not being a string and parameter and item not being parameter or item', function () {
    $itemFieldData = ['value' => 123, 'parameterId' => 'invalid-parameter-id', 'itemId' => 'invalid-item-id'];
    $itemFieldExpectedResult = [...$itemFieldData, 'userId' => 'userId'];
    $this->assertDatabaseMissing('item_fields', $itemFieldExpectedResult);

    $response = $this->postJson('/api/item_fields', $itemFieldData);
    $response->assertStatus(422)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'value',
                'parameterId',
                'itemId',
            ],
        ])
        ->assertJson([
            'success' => false,
            'message' => 'ItemFieldas not successfully created.',
            'data' => [
                'value' => [
                    'The value field must be a string.',
                ],
                'itemId' => [
                    'No item found for this itemId.',
                ],
                'parameterId' => [
                    'No parameter found for this parameterId.',
                ],
            ],
        ]);

    $this->assertDatabaseMissing('item_fields', $itemFieldExpectedResult);
});
