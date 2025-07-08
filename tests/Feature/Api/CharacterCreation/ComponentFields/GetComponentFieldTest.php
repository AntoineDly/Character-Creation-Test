<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\ComponentFields\Models\ComponentField;
use App\Components\Models\Component;
use App\Parameters\Enums\TypeParameterEnum;
use App\Parameters\Models\Parameter;

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

it('get componentField with valid componentField uuid should return 200 with the componentField', function () {
    $component = Component::factory()->create(['user_id' => $this->getUserId()]);
    $parameter = Parameter::factory()->create(['type' => TypeParameterEnum::STRING, 'user_id' => $this->getUserId()]);
    $componentField = ComponentField::factory()->create([
        'value' => 'test',
        'parameter_id' => $parameter->id,
        'component_id' => $component->id,
        'user_id' => $this->getUserId(),
    ]);

    $response = $this->getJson('/api/component_fields/'.$componentField->id);
    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
                'value',
            ],
        ])
        ->assertJson([
            'success' => true,
            'message' => 'ComponentFieldas successfully retrieved.',
            'data' => [
                'id' => $componentField->id,
                'value' => $componentField->value,
            ],
        ]);
});

it('get componentField with invalid componentField uuid should return 404 with the game not found.', function () {
    $response = $this->getJson('/api/component_fields/invalid-uuid');
    $response->assertStatus(404)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => false,
            'message' => 'ComponentField not found.',
        ]);
});
