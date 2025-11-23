<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Components\Domain\Models\Component;
use App\Parameters\Domain\Enums\TypeParameterEnum;
use App\Parameters\Domain\Models\Parameter;

it('create componentFields should return 201 with a new component created', function () {
    $component = Component::factory()->create(['user_id' => $this->getUserId()]);
    $parameter = Parameter::factory()->create(['type' => TypeParameterEnum::STRING, 'user_id' => $this->getUserId()]);

    $componentFieldData = ['value' => 'string', 'parameterId' => $parameter->id, 'componentId' => $component->id];
    $componentFieldExpectedResult = ['value' => 'string', 'parameter_id' => $parameter->id, 'component_id' => $component->id, 'user_id' => $this->getUserId()];
    $this->assertDatabaseMissing('component_fields', $componentFieldExpectedResult);

    $response = $this->postJson('/api/component_fields', $componentFieldData);
    $response->assertStatus(201)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => true,
            'message' => 'ComponentField was successfully created.',
        ]);

    $this->assertDatabaseHas('component_fields', $componentFieldExpectedResult);
});

it('create componentFields should return 422 with value not being a string and parameter and component not being parameter or component', function () {
    $componentFieldData = ['value' => 123, 'parameterId' => 'invalid-parameter-id', 'componentId' => 'invalid-component-id'];
    $componentFieldExpectedResult = [...$componentFieldData, 'user_id' => $this->getUserId()];
    $this->assertDatabaseMissing('item_fields', $componentFieldExpectedResult);

    $response = $this->postJson('/api/component_fields', $componentFieldData);
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
            'message' => 'ComponentField was not successfully created.',
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

    $this->assertDatabaseMissing('item_fields', $componentFieldExpectedResult);
});
