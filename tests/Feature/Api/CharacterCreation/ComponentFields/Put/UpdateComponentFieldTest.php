<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\ComponentFields\Domain\Models\ComponentField;
use App\Components\Domain\Models\Component;
use App\Parameters\Domain\Enums\TypeParameterEnum;
use App\Parameters\Domain\Models\Parameter;

it('update componentFields should return 201 with componentFields updated', function () {
    $component = Component::factory()->create(['user_id' => $this->getUserId()]);
    $parameter = Parameter::factory()->create(['type' => TypeParameterEnum::STRING, 'user_id' => $this->getUserId()]);
    $componentFieldData = [
        'value' => 'test',
        'parameter_id' => $parameter->id,
        'component_id' => $component->id,
        'user_id' => $this->getUserId(),
    ];
    $componentFieldNewData = [
        'value' => 'newTest',
        'parameterId' => $parameter->id,
        'componentId' => $component->id,
    ];

    $componentField = ComponentField::factory()->create($componentFieldData);

    $this->assertDatabaseHas('component_fields', $componentFieldData);
    $componentFieldExpectedResult = [
        'value' => 'newTest',
        'parameter_id' => $parameter->id,
        'component_id' => $component->id,
        'user_id' => $this->getUserId()];

    $response = $this->putJson(
        '/api/component_fields/'.$componentField->id,
        $componentFieldNewData
    );
    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
        ])
        ->assertJson([
            'success' => true,
            'message' => 'ComponentField was successfully updated.',
        ]);

    $this->assertDatabaseHas('component_fields', $componentFieldExpectedResult);
});
