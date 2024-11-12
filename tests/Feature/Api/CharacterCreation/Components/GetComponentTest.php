<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Components\Models\Component;

it('get components should return 200 without any games', function () {
    $response = $this->getJson('/api/components');
    $response->assertStatus(200)
        ->assertJsonStructure(['success', 'message', 'data'])
        ->assertJson([
            'success' => true,
            'message' => 'Components were successfully retrieved.',
            'data' => [
                [],
            ],
        ]);
});

it('get components should return 200 with games', function () {
    $component = Component::factory()->create(['user_id' => $this->getUserId()]);

    $response = $this->getJson('/api/components');
    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                [
                    [
                        'id',
                    ],
                ],
            ],
        ])
        ->assertJson([
            'success' => true,
            'message' => 'Components were successfully retrieved.',
            'data' => [
                [
                    [
                        'id' => $component->id,
                    ],
                ],
            ],
        ]);
});

it('get component with valid game uuid should return 200 with the game', function () {
    $component = Component::factory()->create(['user_id' => $this->getUserId()]);

    $response = $this->getJson('/api/components/'.$component->id);
    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                [
                    'id',
                ],
            ],
        ])
        ->assertJson([
            'success' => true,
            'message' => 'Component was successfully retrieved.',
            'data' => [
                [
                    'id' => $component->id,
                ],
            ],
        ]);
});

it('get component with invalid game uuid should return 404 with the game not found.', function () {
    $response = $this->getJson('/api/components/invalid-uuid');
    $response->assertStatus(404)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => false,
            'message' => 'Component not found.',
        ]);
});
