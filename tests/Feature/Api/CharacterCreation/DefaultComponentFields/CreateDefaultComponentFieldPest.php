<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Components\Models\Component;
use App\Parameters\Enums\TypeParameterEnum;
use App\Parameters\Models\Parameter;

it('create defaultComponentFields should return 201 with a new component created', function () {
    $component = Component::factory()->create(['user_id' => $this->getUserId()]);
    $parameter = Parameter::factory()->create(['type' => TypeParameterEnum::STRING, 'user_id' => $this->getUserId()]);

    $defaultComponentFieldData = ['value' => 'string', 'parameterId' => $parameter->id, 'componentId' => $component->id];
    $defaultComponentFieldExpectedResult = [...$defaultComponentFieldData, 'userId' => 'userId'];
    $this->assertDatabaseMissing('default_component_fields', $defaultComponentFieldExpectedResult);

    $response = $this->postJson('/api/default_component_fields', $defaultComponentFieldData);
    $response->assertStatus(201)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => true,
            'message' => 'Default Component Field was successfully created.',
        ]);

    $this->assertDatabaseHas('default_component_fields', $defaultComponentFieldExpectedResult);
});

it('create defaultComponentFields should return 422 with value not being a string and parameter and component not being parameter or component', function () {
    $defaultComponentFieldData = ['value' => 123, 'parameterId' => 'invalid-parameter-id', 'componentId' => 'invalid-component-id'];
    $defaultComponentFieldExpectedResult = [...$defaultComponentFieldData, 'userId' => 'userId'];
    $this->assertDatabaseMissing('parameters', $defaultComponentFieldExpectedResult);

    $response = $this->postJson('/api/default_component_fields', $defaultComponentFieldData);
    $response->assertStatus(422)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'value',
                'parameterId',
                'componentId',
            ],
        ])
        ->assertJson([
            'success' => false,
            'message' => 'Default Component Field was not successfully created.',
            'data' => [
                'value' => [
                    'The value field must be a string.',
                ],
                'componentId' => [
                    'No component found for this componentId.',
                ],
                'parameterId' => [
                    'No parameter found for this parameterId.',
                ],
            ],
        ]);

    $this->assertDatabaseMissing('parameters', $defaultComponentFieldExpectedResult);
});
