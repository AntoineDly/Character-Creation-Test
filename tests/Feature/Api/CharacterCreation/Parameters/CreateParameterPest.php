<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Parameters\Enums\TypeParameterEnum;

it('create parameter should return 201 with a new component created', function () {
    $parameterData = ['name' => 'name', 'type' => TypeParameterEnum::STRING];
    $parameterExpectedResult = [...$parameterData, 'userId' => 'userId'];
    $this->assertDatabaseMissing('parameters', $parameterExpectedResult);

    $response = $this->postJson('/api/parameters', $parameterData);
    $response->assertStatus(201)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => true,
            'message' => 'Parameter was successfully created.',
        ]);

    $this->assertDatabaseHas('parameters', $parameterExpectedResult);
});

it('create parameter should return 422 with name not being a string and type without correct type', function () {
    $parameterData = ['name' => 123, 'type' => 'invalid-type'];
    $parameterExpectedResult = [...$parameterData, 'userId' => 'userId'];
    $this->assertDatabaseMissing('parameters', $parameterExpectedResult);

    $response = $this->postJson('/api/parameters', $parameterData);
    $response->assertStatus(422)
        ->assertJsonStructure(['success', 'message', 'data'])
        ->assertJson([
            'success' => false,
            'message' => 'Parameter was not successfully created.',
            'data' => [
                'name' => [
                    'The name field must be a string.',
                ],
                'type' => [
                    'The selected type is invalid.',
                ],
            ],
        ]);

    $this->assertDatabaseMissing('parameters', $parameterExpectedResult);
});
