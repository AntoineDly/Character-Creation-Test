<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

use App\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('register a new user', function () {
    $userData = [
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
        'password' => 'password',
    ];

    $response = $this->postJson('/api/register', $userData);

    $response->assertStatus(201)
        ->assertJson([
            'message' => 'User created successfully!',
        ]);

    $this->assertDatabaseHas('users', [
        'email' => 'john.doe@example.com',
    ]);
});

it('login with the current user', function () {
    $password = 'test123';
    $user = User::factory()->create(['password' => Hash::make($password)]);

    $userData = [
        'email' => $user->email,
        'password' => $password,
    ];

    $response = $this->postJson('/api/login', $userData);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'access_token',
            'token_type',
        ]);

    $this->assertDatabaseHas('oauth_access_tokens', [
        'user_id' => $user->id,
    ]);
});
