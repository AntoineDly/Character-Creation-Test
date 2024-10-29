<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Games\Models\Game;

it('get games should return 200 without any games', function () {
    $response = $this->getJson('/api/games');
    $response->assertStatus(200)
        ->assertJsonStructure(['success', 'message', 'data'])
        ->assertJson([
            'success' => true,
            'message' => 'Games were successfully retrieved.',
            'data' => [
                [],
            ],
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
                [
                    [
                        'id',
                        'name',
                    ],
                ],
            ],
        ])
        ->assertJson([
            'success' => true,
            'message' => 'Games were successfully retrieved.',
            'data' => [
                [
                    [
                        'id' => $game->id,
                        'name' => $game->name,
                    ],
                ],
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
                [
                    'id',
                    'name',
                ],
            ],
        ])
        ->assertJson([
            'success' => true,
            'message' => 'Game was successfully retrieved.',
            'data' => [
                [
                    'id' => $game->id,
                    'name' => $game->name,
                ],
            ],
        ]);
});

it('get game with invalid game uuid should return 404 with the game not found', function () {
    $response = $this->getJson('/api/games/invalid-uuid');
    $response->assertStatus(404)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => false,
            'message' => 'Game not found',
        ]);
});
