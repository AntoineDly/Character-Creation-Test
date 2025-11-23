<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Categories\Domain\Models\Category;
use App\Components\Domain\Models\Component;

it('create item should return 201 with a new item created', function () {
    $category = Category::factory()->create(['user_id' => $this->getUserId()]);
    $component = Component::factory()->create(['user_id' => $this->getUserId()]);
    $itemData = ['componentId' => $component->id, 'categoryId' => $category->id];
    $itemExpectedResult = ['category_id' => $category->id, 'component_id' => $component->id, 'user_id' => $this->getUserId()];

    $this->assertDatabaseMissing('items', $itemExpectedResult);

    $response = $this->postJson('/api/items', $itemData);
    $response->assertStatus(201)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => true,
            'message' => 'Item was successfully created.',
        ]);

    $this->assertDatabaseHas('items', $itemExpectedResult);
});

it('create item should return 422 with category and component not found', function () {
    $itemData = ['categoryId' => 'invalid-category-uuid', 'componentId' => 'invalid-component-uuid'];
    $itemExpectedResult = ['category_id' => 'invalid-component-uuid', 'component_id' => 'invalid-component-uuid', 'user_id' => $this->getUserId()];
    $this->assertDatabaseMissing('items', $itemExpectedResult);

    $response = $this->postJson('/api/items', $itemData);
    $response->assertStatus(422)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'categoryId',
                'componentId',
            ],
        ])
        ->assertJson([
            'success' => false,
            'message' => 'Item was not successfully created.',
            'data' => [
                'categoryId' => [
                    'No category found for this categoryId.',
                ],
                'componentId' => [
                    'No component found for this componentId.',
                ],
            ],
        ]);

    $this->assertDatabaseMissing('items', $itemExpectedResult);
});
