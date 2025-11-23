<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

it('create component should return 201 with a new component created', function () {
    $componentExpectedResult = ['user_id' => $this->getUserId()];
    $this->assertDatabaseMissing('components', $componentExpectedResult);

    $response = $this->postJson('/api/components');
    $response->assertStatus(201)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => true,
            'message' => 'Component was successfully created.',
        ]);

    $this->assertDatabaseHas('components', $componentExpectedResult);
});
