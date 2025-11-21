<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Parameters\Domain\Models\Parameter;

it('get parameter with valid game uuid should return 200 with the game', function () {
    $parameter = Parameter::factory()->create(['user_id' => $this->getUserId()]);

    $response = $this->getJson('/api/parameters/'.$parameter->id);
    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
                'name',
                'type',
            ],
        ])
        ->assertJson([
            'success' => true,
            'message' => 'Parameter was successfully retrieved.',
            'data' => [
                'id' => $parameter->id,
                'name' => $parameter->name,
                'type' => $parameter->type->value,
            ],
        ]);
});

it('get parameter with invalid game uuid should return 404 with the game not found.', function () {
    $response = $this->getJson('/api/parameters/invalid-uuid');
    $response->assertStatus(404)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => false,
            'message' => 'Parameter not found.',
        ]);
});
