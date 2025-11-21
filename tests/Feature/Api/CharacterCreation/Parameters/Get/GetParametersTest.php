<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Parameters\Domain\Models\Parameter;

it('get parameters should return 200 without any games', function () {
    $response = $this->getJson('/api/parameters');
    $response->assertStatus(200)
        ->assertJsonStructure(['success', 'message', 'data'])
        ->assertJson([
            'success' => true,
            'message' => 'Parameters were successfully retrieved.',
            'data' => [],
        ]);
});

it('get parameters should return 200 with games', function () {
    $parameter = Parameter::factory()->create(['user_id' => $this->getUserId()]);

    $response = $this->getJson('/api/parameters');
    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'dtos' => [
                    [
                        'id',
                        'name',
                        'type',
                    ],
                ],
                'paginationDto' => ['currentPage',
                    'perPage',
                    'total',
                    'firstPage',
                    'previousPage',
                    'nextPage',
                    'lastPage', ],
            ],
        ])
        ->assertJson([
            'success' => true,
            'message' => 'Parameters were successfully retrieved.',
            'data' => [
                'dtos' => [
                    [
                        'id' => $parameter->id,
                        'name' => $parameter->name,
                        'type' => $parameter->type->value,
                    ],
                ],
                'paginationDto' => ['currentPage' => 1,
                    'perPage' => 15,
                    'total' => 1,
                    'firstPage' => null,
                    'previousPage' => null,
                    'nextPage' => null,
                    'lastPage' => null, ],
            ],
        ]);
});
