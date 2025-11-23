<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Categories\Domain\Models\Category;
use App\Characters\Domain\Models\Character;
use App\Components\Domain\Models\Component;
use App\Games\Domain\Models\Game;
use App\Items\Domain\Models\Item;
use App\PlayableItems\Domain\Models\PlayableItem;

it('create linked item should return 201 with a new linked item created', function () {
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
    $linkedItemData = ['characterId' => $character->id, 'playableItemId' => $playableItem->id];
    $linkedItemExpectedResult = ['character_id' => $character->id, 'playable_item_id' => $playableItem->id, 'user_id' => $this->getUserId()];

    $this->assertDatabaseMissing('linked_items', $linkedItemExpectedResult);

    $response = $this->postJson('/api/linked_items', $linkedItemData);
    $response->assertStatus(201)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => true,
            'message' => 'LinkedItem was successfully created.',
        ]);

    $this->assertDatabaseHas('linked_items', $linkedItemExpectedResult);
});

it('create item should return 422 with category and component not found', function () {
    $linkedItemData = ['characterId' => 'invalid-character-uuid', 'playableItemId' => 'invalid-playable-item-id'];
    $linkedItemExpectedResult = ['character_id' => 'invalid-character-uuid', 'playable_item_id' => 'invalid-playable-item-id', 'user_id' => $this->getUserId()];

    $this->assertDatabaseMissing('linked_items', $linkedItemExpectedResult);

    $response = $this->postJson('/api/linked_items', $linkedItemData);
    $response->assertStatus(422)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'characterId',
                'playableItemId',
            ],
        ])
        ->assertJson([
            'success' => false,
            'message' => 'LinkedItem was not successfully created.',
            'data' => [
                'playableItemId' => [
                    'No playable item found for this playableItemId.',
                ],
                'characterId' => [
                    'No character found for this characterId.',
                ],
            ],
        ]);

    $this->assertDatabaseMissing('linked_items', $linkedItemExpectedResult);
});
