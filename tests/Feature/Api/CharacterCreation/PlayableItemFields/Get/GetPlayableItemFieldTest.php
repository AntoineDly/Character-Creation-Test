<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Categories\Domain\Models\Category;
use App\Components\Domain\Models\Component;
use App\Games\Domain\Models\Game;
use App\Items\Domain\Models\Item;
use App\Parameters\Domain\Enums\TypeParameterEnum;
use App\Parameters\Domain\Models\Parameter;
use App\PlayableItemFields\Domain\Models\PlayableItemField;
use App\PlayableItems\Domain\Models\PlayableItem;

it('get playable item field with valid field uuid should return 200 with the field', function () {
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
    $fieldData = [
        'value' => 'test',
        'parameter_id' => $parameter->id,
        'playable_item_id' => $playableItem->id,
        'user_id' => $this->getUserId(),
    ];

    $playableItemField = PlayableItemField::factory()->create($fieldData);

    $response = $this->getJson('/api/playable_item_fields/'.$playableItemField->id);
    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
                'parameterId',
                'name',
                'value',
                'typeParameterEnum',
                'typeFieldEnum',
            ],
        ])
        ->assertJson([
            'success' => true,
            'message' => 'PlayableItem Field was successfully retrieved.',
            'data' => [
                'id' => $playableItemField->id,
                'parameterId' => $parameter->id,
                'name' => $parameter->name,
                'value' => $playableItemField->getValue(),
                'typeParameterEnum' => $parameter->type->value,
                'typeFieldEnum' => $playableItemField->getType()->value,
            ],
        ]);
});

it('get playable item field with invalid field uuid should return 404 with the playable itemField not found.', function () {
    $response = $this->getJson('/api/playable_item_fields/invalid-uuid');
    $response->assertStatus(404)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => false,
            'message' => 'FieldInterface not found.',
        ]);
});
