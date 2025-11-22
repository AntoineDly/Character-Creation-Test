<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Categories\Domain\Models\Category;

it('get all categories should return 200 without any categories', function () {
    $response = $this->getJson('/api/categories_all');
    $response->assertStatus(200)
        ->assertJsonStructure(['success', 'message', 'data'])
        ->assertJson([
            'success' => true,
            'message' => 'All Categories were successfully retrieved.',
            'data' => [],
        ]);
});

it('get all categories should return 200 with categories', function () {
    $category = Category::factory()->create(['user_id' => $this->getUserId()]);

    $response = $this->getJson('/api/categories_all');
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
            'message' => 'All Categories were successfully retrieved.',
            'data' => [
                [
                    'id' => $category->id,
                    'name' => $category->name,
                ],
            ],
        ]);
});
