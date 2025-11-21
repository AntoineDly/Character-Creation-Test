<?php

declare(strict_types=1);

namespace Tests\Feature\Users;

it('create game should return 201 with a new game created', function () {
    $categoryData = ['name' => 'test'];
    $categoryExpectedResult = [...$categoryData, 'userId' => 'userId'];
    $this->assertDatabaseMissing('categories', $categoryExpectedResult);

    $response = $this->postJson('/api/categories', $categoryData);
    $response->assertStatus(201)
        ->assertJsonStructure(['success', 'message'])
        ->assertJson([
            'success' => true,
            'message' => 'Category was successfully created.',
        ]);

    $this->assertDatabaseHas('categories', $categoryExpectedResult);
});

it('create game should return 422 with name parameter not being a string and visibleForAll being required', function () {
    $categoryData = ['name' => 123];
    $categoryExpectedResult = [...$categoryData, 'userId' => 'userId'];
    $this->assertDatabaseMissing('categories', $categoryExpectedResult);

    $response = $this->postJson('/api/categories', $categoryData);
    $response->assertStatus(422)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'name',
            ],
        ])
        ->assertJson([
            'success' => false,
            'message' => 'Category was not successfully created.',
            'data' => [
                'name' => [
                    'The name field must be a string.',
                ],
            ],
        ]);

    $this->assertDatabaseMissing('categories', $categoryExpectedResult);
});
