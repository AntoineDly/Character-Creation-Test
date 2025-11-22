<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Characters\Domain\Models\Character;
use App\Games\Domain\Models\Game;

it('get character with valid game uuid should return 200 with the character', function () {
    $game = Game::factory()->create(['user_id' => $this->getUserId()]);
    $character = Character::factory()->create(['game_id' => $game->id, 'user_id' => $this->getUserId()]);

    $response = $this->getJson('/api/characters/'.$character->id);
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
            'message' => 'Character was successfully retrieved.',
            'data' => [
                'id' => $character->id,
            ],
        ]);
});

it('get character with invalid character uuid should return 404 with the character not found.', function () {
    $response = $this->getJson('/api/characters/invalid-uuid');

    $response->assertStatus(404)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => false,
            'message' => 'Character not found.',
        ]);
});
