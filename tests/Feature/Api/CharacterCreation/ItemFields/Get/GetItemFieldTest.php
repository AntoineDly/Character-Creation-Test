<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Categories\Domain\Models\Category;
use App\Components\Domain\Models\Component;
use App\ItemFields\Domain\Models\ItemField;
use App\Items\Domain\Models\Item;
use App\Parameters\Domain\Enums\TypeParameterEnum;
use App\Parameters\Domain\Models\Parameter;

it('get itemField with valid itemField uuid should return 200 with the itemField', function () {
    $category = Category::factory()->create(['user_id' => $this->getUserId()]);
    $component = Component::factory()->create(['user_id' => $this->getUserId()]);
    $item = Item::factory()->create([
        'category_id' => $category->id,
        'component_id' => $component->id,
        'user_id' => $this->getUserId(),
    ]);
    $parameter = Parameter::factory()->create(['type' => TypeParameterEnum::STRING, 'user_id' => $this->getUserId()]);
    $itemField = ItemField::factory()->create([
        'value' => 'test',
        'parameter_id' => $parameter->id,
        'item_id' => $item->id,
        'user_id' => $this->getUserId(),
    ]);

    $response = $this->getJson('/api/item_fields/'.$itemField->id);
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
            'message' => 'ItemField was successfully retrieved.',
            'data' => [
                'id' => $itemField->id,
                'value' => $itemField->value,
            ],
        ]);
});

it('get itemField with invalid itemField uuid should return 404 with the game not found.', function () {
    $response = $this->getJson('/api/item_fields/invalid-uuid');
    $response->assertStatus(404)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => false,
            'message' => 'ItemField not found.',
        ]);
});
