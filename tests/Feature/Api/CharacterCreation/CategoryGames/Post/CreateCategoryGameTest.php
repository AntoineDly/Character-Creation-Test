<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Categories\Domain\Models\Category;
use App\Games\Domain\Models\Game;

it('create categoryGame should return 201 with a new association created', function () {
    $category = Category::factory()->create(['user_id' => $this->getUserId()]);
    $game = Game::factory()->create(['user_id' => $this->getUserId()]);
    $categoryData = ['gameId' => $game->id, 'categoryId' => $category->id];
    $categoryExpectedResult = ['game_id' => $game->id, 'category_id' => $category->id];
    $this->assertDatabaseMissing('category_game', $categoryExpectedResult);

    $response = $this->postJson('/api/category_games', $categoryData);
    $response->assertStatus(201)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => true,
            'message' => 'CategoryGame was successfully created.',
        ]);

    $this->assertDatabaseHas('category_game', $categoryExpectedResult);
});

it('create categoryGame should return 422 with gameId parameter not being an existing game id and categoryId being required', function () {
    $categoryData = ['gameId' => 'test'];
    $categoryExpectedResult = [...$categoryData];
    $this->assertDatabaseMissing('category_game', $categoryExpectedResult);

    $response = $this->postJson('/api/category_games', $categoryData);
    $response->assertStatus(422)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'categoryId',
                'gameId',
            ],
        ])
        ->assertJson([
            'success' => false,
            'message' => 'CategoryGame was not successfully created.',
            'data' => [
                'categoryId' => [
                    'The categoryId field is required.',
                ],
                'gameId' => [
                    'No game found for this gameId.',
                ],
            ],
        ]);

    $this->assertDatabaseMissing('category_game', $categoryExpectedResult);
});
