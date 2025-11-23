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

it('update partially playable item field should return 201 with fields updated partially', function () {
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
    $fieldNewData = [
        'value' => 'newTest',
    ];

    $field = PlayableItemField::factory()->create($fieldData);

    $this->assertDatabaseHas('playable_item_fields', $fieldData);
    $fieldExpectedResult = [...$fieldNewData, 'user_id' => $this->getUserId()];

    $response = $this->patchJson(
        '/api/playable_item_fields/'.$field->id,
        $fieldNewData
    );
    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
        ])
        ->assertJson([
            'success' => true,
            'message' => 'PlayableItem Field was successfully updated partially.',
        ]);

    $this->assertDatabaseHas('playable_item_fields', $fieldExpectedResult);
});
