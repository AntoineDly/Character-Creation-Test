<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Games\Domain\Models\Game;

it('create character should return 201 with a new character created', function () {
    $game = Game::factory()->create(['user_id' => $this->getUserId()]);
    $characterData = ['gameId' => $game->id];
    $characterExpectedResult = ['gameId' => 'gameId', 'userId' => 'userId'];
    $this->assertDatabaseMissing('characters', $characterExpectedResult);

    $response = $this->postJson('/api/characters', $characterData);
    $response->assertStatus(201)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => true,
            'message' => 'Character was successfully created.',
        ]);

    $this->assertDatabaseHas('characters', $characterExpectedResult);
});

it('create character should return 422 with game not found', function () {
    $characterData = ['gameId' => 'invalid-uuid'];
    $characterExpectedResult = ['gameId' => 'gameId', 'userId' => 'userId'];
    $this->assertDatabaseMissing('characters', $characterExpectedResult);

    $response = $this->postJson('/api/characters', $characterData);
    $response->assertStatus(422)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'gameId',
            ],
        ])
        ->assertJson([
            'success' => false,
            'message' => 'Character was not successfully created.',
            'data' => [
                'gameId' => [
                    'No game found for this gameId.',
                ],
            ],
        ]);

    $this->assertDatabaseMissing('characters', $characterExpectedResult);
});
