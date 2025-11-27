<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Categories\Domain\Models\Category;
use App\Characters\Domain\Models\Character;
use App\Components\Domain\Models\Component;
use App\Games\Domain\Models\Game;
use App\Items\Domain\Models\Item;
use App\LinkedItemFields\Domain\Models\LinkedItemField;
use App\LinkedItems\Domain\Models\LinkedItem;
use App\Parameters\Domain\Enums\TypeParameterEnum;
use App\Parameters\Domain\Models\Parameter;
use App\PlayableItems\Domain\Models\PlayableItem;

it('get linked item fields should return 200 without any fields', function () {
    $response = $this->getJson('/api/linked_item_fields');
    $response->assertStatus(200)
        ->assertJsonStructure(['success', 'message', 'data'])
        ->assertJson([
            'success' => true,
            'message' => 'LinkedItem Fields were successfully retrieved.',
            'data' => [],
        ]);
});

it('get linked item fields should return 200 with fields', function () {
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

    $linkedItemField = LinkedItemField::factory()->create($fieldData);

    $response = $this->getJson('/api/linked_item_fields');
    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'dtos' => [
                    $parameter->name => [
                        'id',
                        'parameterId',
                        'name',
                        'value',
                        'typeParameterEnum',
                        'typeFieldEnum',
                    ],
                ],
                'paginationDto' => ['currentPage',
                    'perPage',
                    'total',
                    'firstPage',
                    'previousPage',
                    'nextPage',
                    'lastPage',
                ],
            ],
        ])
        ->assertJson([
            'success' => true,
            'message' => 'LinkedItem Fields were successfully retrieved.',
            'data' => [
                'dtos' => [
                    $parameter->name => [
                        'id' => $linkedItemField->id,
                        'parameterId' => $parameter->id,
                        'name' => $parameter->name,
                        'value' => $linkedItemField->getValue(),
                        'typeParameterEnum' => $parameter->type->value,
                        'typeFieldEnum' => $linkedItemField->getType()->value,
                    ],
                ],
                'paginationDto' => ['currentPage' => 1,
                    'perPage' => 15,
                    'total' => 1,
                    'firstPage' => null,
                    'previousPage' => null,
                    'nextPage' => null,
                    'lastPage' => null, ],
            ],
        ]);
});
