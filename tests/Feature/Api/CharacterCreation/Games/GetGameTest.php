<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Categories\Models\Category;
use App\Components\Models\Component;
use App\Games\Models\Game;
use App\Items\Models\Item;
use App\PlayableItems\Models\PlayableItem;

it('get games should return 200 without any games', function () {
    $response = $this->getJson('/api/games');
    $response->assertStatus(200)
        ->assertJsonStructure(['success', 'message', 'data'])
        ->assertJson([
            'success' => true,
            'message' => 'Games were successfully retrieved.',
            'data' => [],
        ]);
});

it('get games should return 200 with games', function () {
    $game = Game::factory()->create(['user_id' => $this->getUserId()]);

    $response = $this->getJson('/api/games');
    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'dtos' => [
                    [
                        'id',
                        'name',
                    ],
                ],
                'currentPage',
                'perPage',
                'total',
                'firstPage',
                'previousPage',
                'nextPage',
                'lastPage',
            ],
        ])
        ->assertJson([
            'success' => true,
            'message' => 'Games were successfully retrieved.',
            'data' => [
                'dtos' => [
                    [
                        'id' => $game->id,
                        'name' => $game->name,
                    ],
                ],
                'currentPage' => 1,
                'perPage' => 15,
                'total' => 1,
                'firstPage' => null,
                'previousPage' => null,
                'nextPage' => null,
                'lastPage' => null,
            ],
        ]);
});

it('get game with valid game uuid should return 200 with the game', function () {
    $game = Game::factory()->create(['user_id' => $this->getUserId()]);

    $response = $this->getJson('/api/games/'.$game->id);
    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
                'name',
            ],
        ])
        ->assertJson([
            'success' => true,
            'message' => 'Game was successfully retrieved.',
            'data' => [
                'id' => $game->id,
                'name' => $game->name,
            ],
        ]);
});

it('get game with invalid game uuid should return 404 with the game not found.', function () {
    $response = $this->getJson('/api/games/invalid-uuid');
    $response->assertStatus(404)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => false,
            'message' => 'Game not found.',
        ]);
});

it('get game with categories and components with valid game uuid should return 200 with the game', function () {
    $game = Game::factory()->create(['user_id' => $this->getUserId()]);
    $category = Category::factory()->create(['user_id' => $this->getUserId()]);
    $component = Component::factory()->create(['user_id' => $this->getUserId()]);
    $item = Item::factory()->create([
        'category_id' => $category->id,
        'component_id' => $component->id,
        'user_id' => $this->getUserId(),
    ]);
    $playableItem = PlayableItem::factory()->create([
        'item_id' => $item->id,
        'game_id' => $game->id,
        'user_id' => $this->getUserId(),
    ]);
    $game->categories()->save($category);

    $response = $this->getJson('/api/games/'.$game->id.'/with_categories_and_playable_items');
    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
                'name',
            ],
        ])
        ->assertJson([
            'success' => true,
            'message' => 'Game was successfully retrieved.',
            'data' => [
                'id' => $game->id,
                'name' => $game->name,
                'categoryDtos' => [
                    [
                        'id' => $category->id,
                        'name' => $category->name,
                    ],
                ],
                'playableItemDtos' => [
                    [
                        'id' => $playableItem->id,
                    ],
                ],
            ],
        ]);
});

it('get game with categories and components with invalid game uuid should return 404 with the game not found.', function () {
    $response = $this->getJson('/api/games/invalid-uuid/with_categories_and_playable_items');
    $response->assertStatus(404)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => false,
            'message' => 'Game not found.',
        ]);
});
