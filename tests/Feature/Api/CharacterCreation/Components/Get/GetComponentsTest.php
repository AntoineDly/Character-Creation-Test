<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Components\Domain\Models\Component;

it('get components should return 200 without any games', function () {
    $response = $this->getJson('/api/components');
    $response->assertStatus(200)
        ->assertJsonStructure(['success', 'message', 'data'])
        ->assertJson([
            'success' => true,
            'message' => 'Components were successfully retrieved.',
            'data' => [],
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
            'message' => 'Components were successfully retrieved.',
            'data' => [
                'dtos' => [
                    [
                        'id' => $component->id,
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
