<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Users\Models\User;
use Illuminate\Support\Facades\Hash;

it('login with the current user should return a 200 with the user being logged in', function () {
    $password = 'test123';
    $user = User::factory()->create(['password' => Hash::make($password)]);

    $userData = [
        'email' => $user->email,
        'password' => $password,
    ];

    $response = $this->postJson('/api/login', $userData);
    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                [
                    'id',
                    'email',
                    'token',
                ],
            ],
        ])
        ->assertJson([
            'success' => true,
            'message' => 'You have been successfully logged in!',
        ]);

    $this->assertDatabaseHas('oauth_access_tokens', [
        'user_id' => $user->id,
    ]);
});

it('login with the current user should return a 422 with fields required', function () {
    $userData = [
    ];

    $response = $this->postJson('/api/login', $userData);

    $response->assertStatus(422)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'email',
                'password',
            ],
        ])
        ->assertJson([
            'success' => false,
            'message' => 'You haven\'t been logged in.',
            'data' => [
                'email' => [
                    'The email field is required.',
                ],
                'password' => [
                    'The password field is required.',
                ],
            ],
        ]);
});

it('login with the current user should return a 404 with the user not existing', function () {
    $userData = [
        'email' => 'john.doe@example.com',
        'password' => 'test123',
    ];

    $response = $this->postJson('/api/login', $userData);

    $response->assertStatus(404)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => false,
            'message' => 'User not found.',
        ]);
});
