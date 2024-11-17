<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Categories\Models\Category;
use App\Components\Models\Component;
use App\DefaultItemFields\Models\DefaultItemField;
use App\Items\Models\Item;
use App\Parameters\Enums\TypeParameterEnum;
use App\Parameters\Models\Parameter;

it('get defaultItemFields should return 200 without any defaultItemFields', function () {
    $response = $this->getJson('/api/default_item_fields');
    $response->assertStatus(200)
        ->assertJsonStructure(['success', 'message', 'data'])
        ->assertJson([
            'success' => true,
            'message' => 'Default Item Fields were successfully retrieved.',
            'data' => [],
        ]);
});

it('get defaultItemFields should return 200 with defaultItemFields', function () {
    $category = Category::factory()->create(['user_id' => $this->getUserId()]);
    $component = Component::factory()->create(['user_id' => $this->getUserId()]);
    $item = Item::factory()->create([
        'category_id' => $category->id,
        'component_id' => $component->id,
        'user_id' => $this->getUserId(),
    ]);
    $parameter = Parameter::factory()->create(['type' => TypeParameterEnum::STRING, 'user_id' => $this->getUserId()]);
    $defaultItemField = DefaultItemField::factory()->create([
        'value' => 'test',
        'parameter_id' => $parameter->id,
        'item_id' => $item->id,
        'user_id' => $this->getUserId(),
    ]);

    $response = $this->getJson('/api/default_item_fields');
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
            'message' => 'Default Item Fields were successfully retrieved.',
            'data' => [
                [
                    'id' => $defaultItemField->id,
                    'value' => $defaultItemField->value,
                ],
            ],
        ]);
});

it('get defaultItemField with valid defaultItemField uuid should return 200 with the defaultItemField', function () {
    $category = Category::factory()->create(['user_id' => $this->getUserId()]);
    $component = Component::factory()->create(['user_id' => $this->getUserId()]);
    $item = Item::factory()->create([
        'category_id' => $category->id,
        'component_id' => $component->id,
        'user_id' => $this->getUserId(),
    ]);
    $parameter = Parameter::factory()->create(['type' => TypeParameterEnum::STRING, 'user_id' => $this->getUserId()]);
    $defaultItemField = DefaultItemField::factory()->create([
        'value' => 'test',
        'parameter_id' => $parameter->id,
        'item_id' => $item->id,
        'user_id' => $this->getUserId(),
    ]);

    $response = $this->getJson('/api/default_item_fields/'.$defaultItemField->id);
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
            'message' => 'Default Item Field was successfully retrieved.',
            'data' => [
                'id' => $defaultItemField->id,
                'value' => $defaultItemField->value,
            ],
        ]);
});

it('get defaultItemField with invalid defaultItemField uuid should return 404 with the game not found.', function () {
    $response = $this->getJson('/api/default_item_fields/invalid-uuid');
    $response->assertStatus(404)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => false,
            'message' => 'Default Item Field not found.',
        ]);
});
