<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Categories\Models\Category;
use App\Characters\Models\Character;
use App\Components\Models\Component;
use App\Games\Models\Game;
use App\Items\Models\Item;
use App\LinkedItemFields\Models\LinkedItemField;
use App\LinkedItems\Models\LinkedItem;
use App\Parameters\Enums\TypeParameterEnum;
use App\Parameters\Models\Parameter;
use App\PlayableItems\Models\PlayableItem;

it('update partially linked item field should return 201 with fields updated partially', function () {
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
    $fieldData = [
        'value' => 'test',
        'parameter_id' => $parameter->id,
        'linked_item_id' => $linkedItem->id,
        'user_id' => $this->getUserId(),
    ];
    $fieldNewData = [
        'value' => 'newTest',
    ];

    $field = LinkedItemField::factory()->create($fieldData);

    $this->assertDatabaseHas('linked_item_fields', $fieldData);
    $fieldExpectedResult = [...$fieldNewData, 'user_id' => $this->getUserId()];

    $response = $this->patchJson(
        '/api/linked_item_fields/'.$field->id,
        $fieldNewData
    );
    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
        ])
        ->assertJson([
            'success' => true,
            'message' => 'Linked Item Field was successfully updated partially.',
        ]);

    $this->assertDatabaseHas('linked_item_fields', $fieldExpectedResult);
});

it('update linked item field should return 201 with fields updated', function () {
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

    $field = LinkedItemField::factory()->create($fieldData);

    $this->assertDatabaseHas('linked_item_fields', $fieldData);
    $fieldExpectedResult = [
        'value' => 'newTest',
        'parameter_id' => $parameter->id,
        'linked_item_id' => $linkedItem->id,
        'user_id' => $this->getUserId(),
    ];

    $response = $this->putJson(
        '/api/linked_item_fields/'.$field->id,
        $fieldNewData
    );
    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
        ])
        ->assertJson([
            'success' => true,
            'message' => 'Linked Item Field was successfully updated.',
        ]);

    $this->assertDatabaseHas('linked_item_fields', $fieldExpectedResult);
});
