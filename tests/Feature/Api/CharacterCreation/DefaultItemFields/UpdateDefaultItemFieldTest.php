<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Categories\Models\Category;
use App\Components\Models\Component;
use App\DefaultItemFields\Models\DefaultItemField;
use App\Items\Models\Item;
use App\Parameters\Enums\TypeParameterEnum;
use App\Parameters\Models\Parameter;

it('update partially defaultItemFields should return 201 with defaultItemFields updated partially', function () {
    $category = Category::factory()->create(['user_id' => $this->getUserId()]);
    $component = Component::factory()->create(['user_id' => $this->getUserId()]);
    $item = Item::factory()->create([
        'category_id' => $category->id,
        'component_id' => $component->id,
        'user_id' => $this->getUserId(),
    ]);
    $parameter = Parameter::factory()->create(['type' => TypeParameterEnum::STRING, 'user_id' => $this->getUserId()]);
    $defaultItemFieldData = [
        'value' => 'test',
        'parameter_id' => $parameter->id,
        'item_id' => $item->id,
        'user_id' => $this->getUserId(),
    ];
    $defaultItemFieldNewData = [
        'value' => 'newTest',
    ];

    $defaultItemField = DefaultItemField::factory()->create($defaultItemFieldData);

    $this->assertDatabaseHas('default_item_fields', $defaultItemFieldData);
    $defaultItemExpectedResult = [...$defaultItemFieldNewData, 'user_id' => $this->getUserId()];

    $response = $this->patchJson(
        '/api/default_item_fields/'.$defaultItemField->id,
        $defaultItemFieldNewData
    );
    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
        ])
        ->assertJson([
            'success' => true,
            'message' => 'Default Item Field was successfully updated partially.',
        ]);

    $this->assertDatabaseHas('default_item_fields', $defaultItemExpectedResult);
});

it('update defaultItemFields should return 201 with defaultItemFields updated', function () {
    $category = Category::factory()->create(['user_id' => $this->getUserId()]);
    $component = Component::factory()->create(['user_id' => $this->getUserId()]);
    $item = Item::factory()->create([
        'category_id' => $category->id,
        'component_id' => $component->id,
        'user_id' => $this->getUserId(),
    ]);
    $parameter = Parameter::factory()->create(['type' => TypeParameterEnum::STRING, 'user_id' => $this->getUserId()]);
    $defaultItemFieldData = [
        'value' => 'test',
        'parameter_id' => $parameter->id,
        'item_id' => $item->id,
        'user_id' => $this->getUserId(),
    ];
    $defaultItemFieldNewData = [
        'value' => 'newTest',
        'parameterId' => $parameter->id,
        'itemId' => $item->id,
    ];

    $defaultItemField = DefaultItemField::factory()->create($defaultItemFieldData);

    $this->assertDatabaseHas('default_item_fields', $defaultItemFieldData);
    $defaultItemExpectedResult = [
        'value' => 'newTest',
        'parameter_id' => $parameter->id,
        'item_id' => $item->id,
        'user_id' => $this->getUserId()];

    $response = $this->putJson(
        '/api/default_item_fields/'.$defaultItemField->id,
        $defaultItemFieldNewData
    );
    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
        ])
        ->assertJson([
            'success' => true,
            'message' => 'Default Item Field was successfully updated.',
        ]);

    $this->assertDatabaseHas('default_item_fields', $defaultItemExpectedResult);
});
