<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Characters\Domain\Models\Character;
use App\Games\Domain\Models\Game;

it('get characters should return 200 without any characters', function () {
    $response = $this->getJson('/api/characters');
    $response->assertStatus(200)
        ->assertJsonStructure(['success', 'message', 'data'])
        ->assertJson([
            'success' => true,
            'message' => 'Characters were successfully retrieved.',
            'data' => [],
        ]);
});

it('get characters should return 200 with characters', function () {
    $game = Game::factory()->create(['user_id' => $this->getUserId()]);
    $character = Character::factory()->create(['game_id' => $game->id, 'user_id' => $this->getUserId()]);

    $response = $this->getJson('/api/characters');
    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'dtos' => [
                    [
                        'id',
                    ],
                ],
                'paginationDto' => [
                    'currentPage',
                    'perPage',
                    'total',
                    'firstPage',
                    'previousPage',
                    'nextPage',
                    'lastPage',
                ],
            ],
        ])
        ->assertJson([
            'success' => true,
            'message' => 'Characters were successfully retrieved.',
            'data' => [
                'dtos' => [
                    [
                        'id' => $character->id,
                    ],
                ],
                'paginationDto' => [
                    'currentPage' => 1,
                    'perPage' => 15,
                    'total' => 1,
                    'firstPage' => null,
                    'previousPage' => null,
                    'nextPage' => null,
                    'lastPage' => null,
                ],
            ],
        ]);
});
