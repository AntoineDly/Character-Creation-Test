<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

it('logout with the current user should return a 200 with the user being loggout', function () {
    $response = $this->withHeaders([
        'Authorization' => 'Bearer '.$this->getBearerToken(),
    ])->postJson('/api/logout');

    $response->assertStatus(200)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => true,
            'message' => 'You have been successfully logged out!',
        ]);
});

it('logout without the current user should return a 400 unauthenticated', function () {
    $response = $this->postJson('/api/logout');

    $response->assertStatus(401)
        ->assertJsonStructure(['message'])
        ->assertJson([
            'message' => 'Unauthenticated.',
        ]);
});
