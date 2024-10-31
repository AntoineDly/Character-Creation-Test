<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Categories\Models\Category;
use App\Characters\Models\Character;
use App\Components\Models\Component;
use App\Fields\Models\Field;
use App\Games\Models\Game;
use App\Items\Models\Item;
use App\LinkedItems\Models\LinkedItem;
use App\Parameters\Enums\TypeParameterEnum;
use App\Parameters\Models\Parameter;

it('update partially fields should return 201 with fields updated partially', function () {
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
    $fieldData = [
        'value' => 'test',
        'parameter_id' => $parameter->id,
        'linked_item_id' => $linkedItem->id,
        'user_id' => $this->getUserId(),
    ];
    $fieldNewData = [
        'value' => 'newTest',
    ];

    $field = Field::factory()->create($fieldData);

    $this->assertDatabaseHas('fields', $fieldData);
    $fieldExpectedResult = [...$fieldNewData, 'user_id' => $this->getUserId()];

    $response = $this->patchJson(
        '/api/fields/'.$field->id,
        $fieldNewData
    );
    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
        ])
        ->assertJson([
            'success' => true,
            'message' => 'Field was successfully updated partially.',
        ]);

    $this->assertDatabaseHas('fields', $fieldExpectedResult);
});

it('update fields should return 201 with fields updated', function () {
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
    $fieldData = [
        'value' => 'test',
        'parameter_id' => $parameter->id,
        'linked_item_id' => $linkedItem->id,
        'user_id' => $this->getUserId(),
    ];
    $fieldNewData = [
        'value' => 'newTest',
        'parameterId' => $parameter->id,
        'linkedItemId' => $linkedItem->id,
    ];

    $field = Field::factory()->create($fieldData);

    $this->assertDatabaseHas('fields', $fieldData);
    $fieldExpectedResult = [
        'value' => 'newTest',
        'parameter_id' => $parameter->id,
        'linked_item_id' => $linkedItem->id,
        'user_id' => $this->getUserId(),
    ];

    $response = $this->putJson(
        '/api/fields/'.$field->id,
        $fieldNewData
    );
    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
        ])
        ->assertJson([
            'success' => true,
            'message' => 'Field was successfully updated.',
        ]);

    $this->assertDatabaseHas('fields', $fieldExpectedResult);
});
