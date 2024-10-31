<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Categories\Models\Category;
use App\Components\Models\Component;
use App\Items\Models\Item;
use App\Parameters\Enums\TypeParameterEnum;
use App\Parameters\Models\Parameter;

it('create defaultItemField should return 201 with a new defaultItemField created', function () {
    $category = Category::factory()->create(['user_id' => $this->getUserId()]);
    $component = Component::factory()->create(['user_id' => $this->getUserId()]);
    $item = Item::factory()->create([
        'category_id' => $category->id,
        'component_id' => $component->id,
        'user_id' => $this->getUserId(),
    ]);
    $parameter = Parameter::factory()->create(['type' => TypeParameterEnum::STRING, 'user_id' => $this->getUserId()]);

    $defaultItemFieldData = ['value' => 'string', 'parameterId' => $parameter->id, 'itemId' => $item->id];
    $defaultItemFieldExpectedResult = ['value' => 'string', 'parameterId' => 'parameterId', 'itemId' => 'itemId', 'userId' => 'userId'];
    $this->assertDatabaseMissing('default_item_fields', $defaultItemFieldExpectedResult);

    $response = $this->postJson('/api/default_item_fields', $defaultItemFieldData);
    $response->assertStatus(201)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => true,
            'message' => 'Default Item Field was successfully created.',
        ]);

    $this->assertDatabaseHas('default_item_fields', $defaultItemFieldExpectedResult);
});

it('create defaultItemFields should return 422 with value not being a string and parameter and item not being parameter or item', function () {
    $defaultItemFieldData = ['value' => 123, 'parameterId' => 'invalid-parameter-id', 'itemId' => 'invalid-item-id'];
    $defaultItemFieldExpectedResult = [...$defaultItemFieldData, 'userId' => 'userId'];
    $this->assertDatabaseMissing('parameters', $defaultItemFieldExpectedResult);

    $response = $this->postJson('/api/default_item_fields', $defaultItemFieldData);
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
            'message' => 'Default Item Field was not successfully created.',
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

    $this->assertDatabaseMissing('parameters', $defaultItemFieldExpectedResult);
});
