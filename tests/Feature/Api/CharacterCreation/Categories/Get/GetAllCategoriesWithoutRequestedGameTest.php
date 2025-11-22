<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Categories\Domain\Models\Category;
use App\Games\Domain\Models\Game;

it('get all categories without requested game should return 200 without any categories', function () {
    $game = Game::factory()->create(['user_id' => $this->getUserId()]);

    $response = $this->getJson('/api/categories_all_without_requested_game?gameId='.$game->id);
    $response->assertStatus(200)
        ->assertJsonStructure(['success', 'message', 'data'])
        ->assertJson([
            'success' => true,
            'message' => 'All Categories without requested game were successfully retrieved.',
            'data' => [],
        ]);
});

it('get categories without requested game should return 200 with categories not being in requested game', function () {
    $category = Category::factory()->create(['user_id' => $this->getUserId()]);
    $categoryInGame = Category::factory()->create(['user_id' => $this->getUserId()]);
    $game = Game::factory()->create(['user_id' => $this->getUserId()]);
    $game->categories()->save($categoryInGame);

    $response = $this->getJson('/api/categories_all_without_requested_game?gameId='.$game->id);
    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                [
                    'id',
                    'name',
                ],
            ],
        ])
        ->assertJson([
            'success' => true,
            'message' => 'All Categories without requested game were successfully retrieved.',
            'data' => [
                [
                    'id' => $category->id,
                    'name' => $category->name,
                ],
            ],
        ]);
});
