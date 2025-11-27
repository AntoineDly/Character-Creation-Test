<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\ComponentFields\Domain\Models\ComponentField;
use App\Components\Domain\Models\Component;
use App\Parameters\Domain\Enums\TypeParameterEnum;
use App\Parameters\Domain\Models\Parameter;

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
                'parameterId',
                'name',
                'value',
                'typeParameterEnum',
                'typeFieldEnum',
            ],
        ])
        ->assertJson([
            'success' => true,
            'message' => 'ComponentField was successfully retrieved.',
            'data' => [
                'id' => $componentField->id,
                'parameterId' => $parameter->id,
                'name' => $parameter->name,
                'value' => $componentField->getValue(),
                'typeParameterEnum' => $parameter->type->value,
                'typeFieldEnum' => $componentField->getType()->value,
            ],
        ]);
});

it('get componentField with invalid componentField uuid should return 404 with the game not found.', function () {
    $response = $this->getJson('/api/component_fields/invalid-uuid');
    $response->assertStatus(404)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => false,
            'message' => 'FieldInterface not found.',
        ]);
});
