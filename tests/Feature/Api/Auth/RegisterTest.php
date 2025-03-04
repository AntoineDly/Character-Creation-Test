<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

it('register a new user should return a 201 with a new user registered', function () {
    $userData = [
        'email' => 'john.doe@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    $response = $this->postJson('/api/register', $userData);

    $response->assertStatus(201)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => true,
            'message' => 'You have been successfully registered!',
        ]);

    $this->assertDatabaseHas('users', [
        'email' => 'john.doe@example.com',
    ]);
});

it('register a new user should return a 422 with fields required', function () {
    $userData = [
    ];

    $response = $this->postJson('/api/register', $userData);

    $response->assertStatus(422)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'email',
                'password',
                'password_confirmation',
            ],
        ])
        ->assertJson([
            'success' => false,
            'message' => 'You haven\'t been registered.',
            'data' => [
                'email' => [
                    'The email field is required.',
                ],
                'password' => [
                    'The password field is required.',
                ],
                'password_confirmation' => [
                    'The password confirmation field is required.',
                ],
            ],
        ]);
});
