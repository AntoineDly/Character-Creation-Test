<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Categories\Domain\Models\Category;

it('get category with valid game uuid should return 200 with the category', function () {
    $category = Category::factory()->create(['user_id' => $this->getUserId()]);

    $response = $this->getJson('/api/categories/'.$category->id);
    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
                'name',
            ],
        ])
        ->assertJson([
            'success' => true,
            'message' => 'Category was successfully retrieved.',
            'data' => [
                'id' => $category->id,
                'name' => $category->name,
            ],
        ]);
});

it('get category with invalid category uuid should return 404 with the category not found.', function () {
    $response = $this->getJson('/api/categories/invalid-uuid');

    $response->assertStatus(404)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => false,
            'message' => 'Category not found.',
        ]);
});
