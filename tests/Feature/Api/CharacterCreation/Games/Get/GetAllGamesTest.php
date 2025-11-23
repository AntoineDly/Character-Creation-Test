<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Games\Domain\Models\Game;

it('get all games should return 200 without any games', function () {
    $response = $this->getJson('/api/games_all');
    $response->assertStatus(200)
        ->assertJsonStructure(['success', 'message', 'data'])
        ->assertJson([
            'success' => true,
            'message' => 'All games were successfully retrieved.',
            'data' => [],
        ]);
});

it('get all games should return 200 with games', function () {
    $game = Game::factory()->create(['user_id' => $this->getUserId()]);

    $response = $this->getJson('/api/games_all');
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
            'message' => 'All games were successfully retrieved.',
            'data' => [
                [
                    'id' => $game->id,
                    'name' => $game->name,
                ],
            ],
        ]);
});
