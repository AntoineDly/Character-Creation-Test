<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Categories\Domain\Models\Category;
use App\Components\Domain\Models\Component;
use App\Items\Domain\Models\Item;

it('get item with valid item uuid should return 200 with the item', function () {
    $category = Category::factory()->create(['user_id' => $this->getUserId()]);
    $component = Component::factory()->create(['user_id' => $this->getUserId()]);
    $item = Item::factory()->create([
        'category_id' => $category->id,
        'component_id' => $component->id,
        'user_id' => $this->getUserId(),
    ]);

    $response = $this->getJson('/api/items/'.$item->id);
    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
            ],
        ])
        ->assertJson([
            'success' => true,
            'message' => 'Item was successfully retrieved.',
            'data' => [
                'id' => $item->id,
            ],
        ]);
});

it('get item with invalid item uuid should return 404 with the item not found.', function () {
    $response = $this->getJson('/api/items/invalid-uuid');
    $response->assertStatus(404)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => false,
            'message' => 'Item not found.',
        ]);
});
