<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

it('create game should return 201 with a new game created', function () {
    $gameData = ['name' => 'test', 'visibleForAll' => true];
    $response = $this->postJson('/api/games', $gameData);

    $response->assertStatus(201)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => true,
            'message' => 'Game was successfully created.',
        ]);

    $this->assertDatabaseHas('games', [
        'name' => 'test', 'visibleForAll' => 'visibleForAll', 'userId' => $this->getUserId(),
    ]);
});

it('create game should return 422 with name parameter not being a string and visibleForAll being required', function () {
    $gameData = ['name' => 123];
    $response = $this->postJson('/api/games', $gameData);

    $response->assertStatus(422)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'name',
                'visibleForAll',
            ],
        ])
        ->assertJson([
            'success' => false,
            'message' => 'Game was not successfully created.',
            'data' => [
                'name' => [
                    'The name field must be a string.',
                ],
                'visibleForAll' => [
                    'The visibleForAll field is required.',
                ],
            ],
        ]);

    $this->assertDatabaseMissing('games', [
        'name' => 123,
    ]);
});
