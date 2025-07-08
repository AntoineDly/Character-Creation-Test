<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Categories\Models\Category;
use App\Components\Models\Component;
use App\ItemFields\Models\ItemField;
use App\Items\Models\Item;
use App\Parameters\Enums\TypeParameterEnum;
use App\Parameters\Models\Parameter;

it('update partially itemFields should return 201 with itemFields updated partially', function () {
    $category = Category::factory()->create(['user_id' => $this->getUserId()]);
    $component = Component::factory()->create(['user_id' => $this->getUserId()]);
    $item = Item::factory()->create([
        'category_id' => $category->id,
        'component_id' => $component->id,
        'user_id' => $this->getUserId(),
    ]);
    $parameter = Parameter::factory()->create(['type' => TypeParameterEnum::STRING, 'user_id' => $this->getUserId()]);
    $itemFieldData = [
        'value' => 'test',
        'parameter_id' => $parameter->id,
        'item_id' => $item->id,
        'user_id' => $this->getUserId(),
    ];
    $itemFieldNewData = [
        'value' => 'newTest',
    ];

    $itemField = ItemField::factory()->create($itemFieldData);

    $this->assertDatabaseHas('item_fields', $itemFieldData);
    $itemFieldExpectedResult = [...$itemFieldNewData, 'user_id' => $this->getUserId()];

    $response = $this->patchJson(
        '/api/item_fields/'.$itemField->id,
        $itemFieldNewData
    );
    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
        ])
        ->assertJson([
            'success' => true,
            'message' => 'ItemFieldas successfully updated partially.',
        ]);

    $this->assertDatabaseHas('item_fields', $itemFieldExpectedResult);
});

it('update itemFields should return 201 with itemFields updated', function () {
    $category = Category::factory()->create(['user_id' => $this->getUserId()]);
    $component = Component::factory()->create(['user_id' => $this->getUserId()]);
    $item = Item::factory()->create([
        'category_id' => $category->id,
        'component_id' => $component->id,
        'user_id' => $this->getUserId(),
    ]);
    $parameter = Parameter::factory()->create(['type' => TypeParameterEnum::STRING, 'user_id' => $this->getUserId()]);
    $itemFieldData = [
        'value' => 'test',
        'parameter_id' => $parameter->id,
        'item_id' => $item->id,
        'user_id' => $this->getUserId(),
    ];
    $itemFieldNewData = [
        'value' => 'newTest',
        'parameterId' => $parameter->id,
        'itemId' => $item->id,
    ];

    $itemField = ItemField::factory()->create($itemFieldData);

    $this->assertDatabaseHas('item_fields', $itemFieldData);
    $itemFieldExpectedResult = [
        'value' => 'newTest',
        'parameter_id' => $parameter->id,
        'item_id' => $item->id,
        'user_id' => $this->getUserId()];

    $response = $this->putJson(
        '/api/item_fields/'.$itemField->id,
        $itemFieldNewData
    );
    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
        ])
        ->assertJson([
            'success' => true,
            'message' => 'ItemFieldas successfully updated.',
        ]);

    $this->assertDatabaseHas('item_fields', $itemFieldExpectedResult);
});
