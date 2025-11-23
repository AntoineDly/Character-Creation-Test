<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Categories\Domain\Models\Category;
use App\Components\Domain\Models\Component;
use App\Games\Domain\Models\Game;
use App\Items\Domain\Models\Item;
use App\PlayableItems\Domain\Models\PlayableItem;

it('get playable item with valid game uuid should return 200 with the playable item', function () {
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

    $response = $this->getJson('/api/playable_items/'.$playableItem->id);
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
            'message' => 'PlayableItem was successfully retrieved.',
            'data' => [
                'id' => $playableItem->id,
            ],
        ]);
});

it('get playable item with invalid game uuid should return 404 with the playable item not found.', function () {
    $response = $this->getJson('/api/playable_items/invalid-uuid');
    $response->assertStatus(404)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => false,
            'message' => 'PlayableItem not found.',
        ]);
});
