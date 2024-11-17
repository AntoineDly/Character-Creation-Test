<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Components\Models\Component;
use App\DefaultComponentFields\Models\DefaultComponentField;
use App\Parameters\Enums\TypeParameterEnum;
use App\Parameters\Models\Parameter;

it('get defaultComponentFields should return 200 without any defaultComponentFields', function () {
    $response = $this->getJson('/api/default_component_fields');
    $response->assertStatus(200)
        ->assertJsonStructure(['success', 'message', 'data'])
        ->assertJson([
            'success' => true,
            'message' => 'Default Component Fields were successfully retrieved.',
            'data' => [],
        ]);
});

it('get defaultComponentFields should return 200 with defaultComponentFields', function () {
    $component = Component::factory()->create(['user_id' => $this->getUserId()]);
    $parameter = Parameter::factory()->create(['type' => TypeParameterEnum::STRING, 'user_id' => $this->getUserId()]);
    $defaultComponentField = DefaultComponentField::factory()->create([
        'value' => 'test',
        'parameter_id' => $parameter->id,
        'component_id' => $component->id,
        'user_id' => $this->getUserId(),
    ]);

    $response = $this->getJson('/api/default_component_fields');
    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                [
                    'id',
                    'value',
                ],
            ],
        ])
        ->assertJson([
            'success' => true,
            'message' => 'Default Component Fields were successfully retrieved.',
            'data' => [
                [
                    'id' => $defaultComponentField->id,
                    'value' => $defaultComponentField->value,
                ],
            ],
        ]);
});

it('get defaultComponentField with valid defaultComponentField uuid should return 200 with the defaultComponentField', function () {
    $component = Component::factory()->create(['user_id' => $this->getUserId()]);
    $parameter = Parameter::factory()->create(['type' => TypeParameterEnum::STRING, 'user_id' => $this->getUserId()]);
    $defaultComponentField = DefaultComponentField::factory()->create([
        'value' => 'test',
        'parameter_id' => $parameter->id,
        'component_id' => $component->id,
        'user_id' => $this->getUserId(),
    ]);

    $response = $this->getJson('/api/default_component_fields/'.$defaultComponentField->id);
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
            'message' => 'Default Component Field was successfully retrieved.',
            'data' => [
                'id' => $defaultComponentField->id,
                'value' => $defaultComponentField->value,
            ],
        ]);
});

it('get defaultComponentField with invalid defaultComponentField uuid should return 404 with the game not found.', function () {
    $response = $this->getJson('/api/default_component_fields/invalid-uuid');
    $response->assertStatus(404)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => false,
            'message' => 'Default Component Field not found.',
        ]);
});
