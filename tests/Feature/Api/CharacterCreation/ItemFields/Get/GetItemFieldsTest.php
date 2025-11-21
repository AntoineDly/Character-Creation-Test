<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Categories\Domain\Models\Category;
use App\Components\Domain\Models\Component;
use App\ItemFields\Domain\Models\ItemField;
use App\Items\Domain\Models\Item;
use App\Parameters\Domain\Enums\TypeParameterEnum;
use App\Parameters\Domain\Models\Parameter;

it('get itemFields should return 200 without any itemFields', function () {
    $response = $this->getJson('/api/item_fields');
    $response->assertStatus(200)
        ->assertJsonStructure(['success', 'message', 'data'])
        ->assertJson([
            'success' => true,
            'message' => 'ItemFields were successfully retrieved.',
            'data' => [],
        ]);
});

it('get itemFields should return 200 with itemFields', function () {
    $category = Category::factory()->create(['user_id' => $this->getUserId()]);
    $component = Component::factory()->create(['user_id' => $this->getUserId()]);
    $item = Item::factory()->create([
        'category_id' => $category->id,
        'component_id' => $component->id,
        'user_id' => $this->getUserId(),
    ]);
    $parameter = Parameter::factory()->create(['type' => TypeParameterEnum::STRING, 'user_id' => $this->getUserId()]);
    $itemField = ItemField::factory()->create([
        'value' => 'test',
        'parameter_id' => $parameter->id,
        'item_id' => $item->id,
        'user_id' => $this->getUserId(),
    ]);

    $response = $this->getJson('/api/item_fields');
    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'dtos' => [
                    [
                        'id',
                        'value',
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
            'message' => 'ItemFields were successfully retrieved.',
            'data' => [
                'dtos' => [
                    [
                        'id' => $itemField->id,
                        'value' => $itemField->value,
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
