<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\ComponentFields\Domain\Models\ComponentField;
use App\Components\Domain\Models\Component;
use App\Parameters\Domain\Enums\TypeParameterEnum;
use App\Parameters\Domain\Models\Parameter;

it('get componentFields should return 200 without any componentFields', function () {
    $response = $this->getJson('/api/component_fields');
    $response->assertStatus(200)
        ->assertJsonStructure(['success', 'message', 'data'])
        ->assertJson([
            'success' => true,
            'message' => 'ComponentFields were successfully retrieved.',
            'data' => [],
        ]);
});

it('get componentFields should return 200 with componentFields', function () {
    $component = Component::factory()->create(['user_id' => $this->getUserId()]);
    $parameter = Parameter::factory()->create(['type' => TypeParameterEnum::STRING, 'user_id' => $this->getUserId()]);
    $componentField = ComponentField::factory()->create([
        'value' => 'test',
        'parameter_id' => $parameter->id,
        'component_id' => $component->id,
        'user_id' => $this->getUserId(),
    ]);

    $response = $this->getJson('/api/component_fields');
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
            'message' => 'ComponentFields were successfully retrieved.',
            'data' => [
                'dtos' => [
                    [
                        'id' => $componentField->id,
                        'value' => $componentField->value,
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
