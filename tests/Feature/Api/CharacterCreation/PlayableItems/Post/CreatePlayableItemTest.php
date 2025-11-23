<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Categories\Domain\Models\Category;
use App\Components\Domain\Models\Component;
use App\Games\Domain\Models\Game;
use App\Items\Domain\Models\Item;

it('create playable item should return 201 with a new playable item created', function () {
    $category = Category::factory()->create(['user_id' => $this->getUserId()]);
    $component = Component::factory()->create(['user_id' => $this->getUserId()]);
    $item = Item::factory()->create([
        'category_id' => $category->id,
        'component_id' => $component->id,
        'user_id' => $this->getUserId(),
    ]);
    $game = Game::factory()->create(['user_id' => $this->getUserId()]);
    $playableItemData = ['gameId' => $game->id, 'itemId' => $item->id];
    $playableItemExpectedResult = ['game_id' => $game->id, 'item_id' => $item->id, 'user_id' => $this->getUserId()];

    $this->assertDatabaseMissing('playable_items', $playableItemExpectedResult);

    $response = $this->postJson('/api/playable_items', $playableItemData);
    $response->assertStatus(201)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => true,
            'message' => 'PlayableItem was successfully created.',
        ]);

    $this->assertDatabaseHas('playable_items', $playableItemExpectedResult);
});

it('create item should return 422 with category and component not found', function () {
    $playableItemData = ['gameId' => 'invalid-game-uuid', 'itemId' => 'invalid-item-id'];
    $playableItemExpectedResult = ['game_id' => 'invalid-game-uuid', 'item_id' => 'invalid-item-id', 'user_id' => $this->getUserId()];

    $this->assertDatabaseMissing('playable_items', $playableItemExpectedResult);

    $response = $this->postJson('/api/playable_items', $playableItemData);
    $response->assertStatus(422)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'gameId',
                'itemId',
            ],
        ])
        ->assertJson([
            'success' => false,
            'message' => 'PlayableItem was not successfully created.',
            'data' => [
                'itemId' => [
                    'No item found for this itemId.',
                ],
                'gameId' => [
                    'No game found for this gameId.',
                ],
            ],
        ]);

    $this->assertDatabaseMissing('playable_items', $playableItemExpectedResult);
});
