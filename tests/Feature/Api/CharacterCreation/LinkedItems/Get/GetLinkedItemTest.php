<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Categories\Domain\Models\Category;
use App\Characters\Domain\Models\Character;
use App\Components\Domain\Models\Component;
use App\Games\Domain\Models\Game;
use App\Items\Domain\Models\Item;
use App\LinkedItems\Domain\Models\LinkedItem;
use App\PlayableItems\Domain\Models\PlayableItem;

it('get linked item with valid game uuid should return 200 with the linked item', function () {
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

    $response = $this->getJson('/api/linked_items/'.$linkedItem->id);
    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
            ],
        ])
        ->assertJson([
            'success' => true,
            'message' => 'LinkedItem was successfully retrieved.',
            'data' => [
                'id' => $linkedItem->id,
            ],
        ]);
});

it('get linked item with invalid game uuid should return 404 with the linked item not found.', function () {
    $response = $this->getJson('/api/linked_items/invalid-uuid');
    $response->assertStatus(404)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => false,
            'message' => 'LinkedItem not found.',
        ]);
});
