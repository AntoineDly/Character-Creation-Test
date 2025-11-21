<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Categories\Domain\Models\Category;

it('get categories should return 200 without any games', function () {
    $response = $this->getJson('/api/categories');
    $response->assertStatus(200)
        ->assertJsonStructure(['success', 'message', 'data'])
        ->assertJson([
            'success' => true,
            'message' => 'Categories were successfully retrieved.',
            'data' => [],
        ]);
});

it('get categories should return 200 with games', function () {
    $category = Category::factory()->create(['user_id' => $this->getUserId()]);

    $response = $this->getJson('/api/categories');
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
            'message' => 'Categories were successfully retrieved.',
            'data' => [
                'dtos' => [
                    [
                        'id' => $category->id,
                        'name' => $category->name,
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
