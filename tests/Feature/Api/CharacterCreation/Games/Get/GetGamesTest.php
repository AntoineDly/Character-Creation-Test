<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Games\Domain\Models\Game;

it('get games should return 200 without any games', function () {
    $response = $this->getJson('/api/games');
    $response->assertStatus(200)
        ->assertJsonStructure(['success', 'message', 'data'])
        ->assertJson([
            'success' => true,
            'message' => 'Games were successfully retrieved.',
            'data' => [],
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
                'dtos' => [
                    [
                        'id',
                        'name',
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
            'message' => 'Games were successfully retrieved.',
            'data' => [
                'dtos' => [
                    [
                        'id' => $game->id,
                        'name' => $game->name,
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
