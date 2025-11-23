<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Categories\Domain\Models\Category;
use App\Games\Domain\Models\Game;

it('get all games without requested category should return 200 without any games', function () {
    $category = Category::factory()->create(['user_id' => $this->getUserId()]);

    $response = $this->getJson('/api/games_all_without_requested_category?categoryId='.$category->id);
    $response->assertStatus(200)
        ->assertJsonStructure(['success', 'message', 'data'])
        ->assertJson([
            'success' => true,
            'message' => 'All Games without requested category were successfully retrieved.',
            'data' => [],
        ]);
});

it('get all games without requested category should return 200 with games without requested category', function () {
    $game = Game::factory()->create(['user_id' => $this->getUserId()]);
    $gameWithCategory = Game::factory()->create(['user_id' => $this->getUserId()]);
    $category = Category::factory()->create(['user_id' => $this->getUserId()]);

    $gameWithCategory->categories()->save($category);

    $response = $this->getJson('/api/games_all_without_requested_category?categoryId='.$category->id);
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
            'message' => 'All Games without requested category were successfully retrieved.',
            'data' => [
                [
                    'id' => $game->id,
                    'name' => $game->name,
                ],
            ],
        ]);
});
