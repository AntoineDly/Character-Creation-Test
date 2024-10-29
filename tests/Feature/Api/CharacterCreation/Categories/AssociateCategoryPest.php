<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Categories\Models\Category;
use App\Games\Models\Game;

it('associate category with game should return 201 with a new association created', function () {
    $category = Category::factory()->create(['user_id' => $this->getUserId()]);
    $game = Game::factory()->create(['user_id' => $this->getUserId()]);
    $categoryData = ['gameId' => $game->id, 'categoryId' => $category->id];
    $categoryExpectedResult = [...$categoryData, 'userId' => 'userId'];
    $this->assertDatabaseMissing('category_game', $categoryExpectedResult);

    $response = $this->postJson('/api/categories/associate_game', $categoryData);
    $response->assertStatus(201)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => true,
            'message' => 'Game was successfully associated to the category.',
        ]);

    $this->assertDatabaseHas('categories', $categoryExpectedResult);
});

it('associate category with game should return 422 with gameId parameter not being an existing game id and categoryId being required', function () {
    $categoryData = ['gameId' => 'test'];
    $categoryExpectedResult = [...$categoryData, 'userId' => 'userId'];
    $this->assertDatabaseMissing('category_game', $categoryExpectedResult);

    $response = $this->postJson('/api/categories/associate_game', $categoryData);
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
            'message' => 'Game was not successfully associated to the category.',
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
