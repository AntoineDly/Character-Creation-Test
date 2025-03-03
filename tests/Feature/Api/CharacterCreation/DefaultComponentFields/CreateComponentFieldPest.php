<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Components\Models\Component;
use App\Parameters\Enums\TypeParameterEnum;
use App\Parameters\Models\Parameter;

it('create componentFields should return 201 with a new component created', function () {
    $component = Component::factory()->create(['user_id' => $this->getUserId()]);
    $parameter = Parameter::factory()->create(['type' => TypeParameterEnum::STRING, 'user_id' => $this->getUserId()]);

    $componentFieldData = ['value' => 'string', 'parameterId' => $parameter->id, 'componentId' => $component->id];
    $componentFieldExpectedResult = ['value' => 'string', 'parameterId' => 'parameterId', 'componentId' => 'componentId', 'userId' => 'userId'];
    $this->assertDatabaseMissing('component_fields', $componentFieldExpectedResult);

    $response = $this->postJson('/api/component_fields', $componentFieldData);
    $response->assertStatus(201)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => true,
            'message' => 'Component Field was successfully created.',
        ]);

    $this->assertDatabaseHas('component_fields', $componentFieldExpectedResult);
});

it('create componentFields should return 422 with value not being a string and parameter and component not being parameter or component', function () {
    $componentFieldData = ['value' => 123, 'parameterId' => 'invalid-parameter-id', 'componentId' => 'invalid-component-id'];
    $componentFieldExpectedResult = [...$componentFieldData, 'userId' => 'userId'];
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
            'message' => 'Component Field was not successfully created.',
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
