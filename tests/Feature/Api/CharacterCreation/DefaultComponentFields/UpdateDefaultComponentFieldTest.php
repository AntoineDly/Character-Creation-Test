<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Components\Models\Component;
use App\DefaultComponentFields\Models\DefaultComponentField;
use App\Parameters\Enums\TypeParameterEnum;
use App\Parameters\Models\Parameter;

it('update partially defaultComponentFields should return 201 with defaultComponentFields updated partially', function () {
    $component = Component::factory()->create(['user_id' => $this->getUserId()]);
    $parameter = Parameter::factory()->create(['type' => TypeParameterEnum::STRING, 'user_id' => $this->getUserId()]);
    $defaultComponentFieldData = [
        'value' => 'test',
        'parameter_id' => $parameter->id,
        'component_id' => $component->id,
        'user_id' => $this->getUserId(),
    ];
    $defaultComponentFieldNewData = [
        'value' => 'newTest',
    ];

    $defaultComponentField = DefaultComponentField::factory()->create($defaultComponentFieldData);

    $this->assertDatabaseHas('default_component_fields', $defaultComponentFieldData);
    $defaultComponentFieldExpectedResult = [...$defaultComponentFieldNewData, 'user_id' => $this->getUserId()];

    $response = $this->patchJson(
        '/api/default_component_fields/'.$defaultComponentField->id,
        $defaultComponentFieldNewData
    );
    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
        ])
        ->assertJson([
            'success' => true,
            'message' => 'Default Component Field was successfully updated partially.',
        ]);

    $this->assertDatabaseHas('default_component_fields', $defaultComponentFieldExpectedResult);
});

it('update defaultComponentFields should return 201 with defaultComponentFields updated', function () {
    $component = Component::factory()->create(['user_id' => $this->getUserId()]);
    $parameter = Parameter::factory()->create(['type' => TypeParameterEnum::STRING, 'user_id' => $this->getUserId()]);
    $defaultComponentFieldData = [
        'value' => 'test',
        'parameter_id' => $parameter->id,
        'component_id' => $component->id,
        'user_id' => $this->getUserId(),
    ];
    $defaultComponentFieldNewData = [
        'value' => 'newTest',
        'parameterId' => $parameter->id,
        'componentId' => $component->id,
    ];

    $defaultComponentField = DefaultComponentField::factory()->create($defaultComponentFieldData);

    $this->assertDatabaseHas('default_component_fields', $defaultComponentFieldData);
    $defaultComponentFieldExpectedResult = [
        'value' => 'newTest',
        'parameter_id' => $parameter->id,
        'component_id' => $component->id,
        'user_id' => $this->getUserId()];

    $response = $this->putJson(
        '/api/default_component_fields/'.$defaultComponentField->id,
        $defaultComponentFieldNewData
    );
    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
        ])
        ->assertJson([
            'success' => true,
            'message' => 'Default Component Field was successfully updated.',
        ]);

    $this->assertDatabaseHas('default_component_fields', $defaultComponentFieldExpectedResult);
});
