<?php

declare(strict_types=1);

namespace Tests\TestCases;

use App\Users\Domain\Models\User;
use DateTime;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

abstract class ApiTestCase extends BaseTestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createClient();
    }

    private function createClient(): void
    {
        $clientId = Str::uuid();
        DB::table('oauth_clients')->insert([
            'id' => $clientId,
            'user_id' => '9305c360-caf4-476c-a39a-df82aa895a3d',
            'name' => 'Test Personal Access Client',
            'secret' => 'nJ3XoLTGejz91W4lqyGYwjguYjlXM5UyGnYPWiai',
            'provider' => null,  // or your actual provider value
            'redirect' => 'http://localhost',
            'personal_access_client' => 1,
            'password_client' => 0,
            'revoked' => 0,
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('oauth_personal_access_clients')->insert([
            'client_id' => $clientId,
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);
    }

    public function getUserId(): string
    {
        return $this->user->id;
    }

    public function getBearerToken(string $password = 'test123'): string
    {
        $this->user = User::factory()->create(['password' => Hash::make($password)]);

        $userData = [
            'email' => $this->user->email,
            'password' => $password,
        ];

        $response = $this->postJson('/api/login', $userData);
        /** @var array{'id': string, 'email': string, 'token': string} $data */
        $data = $response->json('data');

        return $data['token'];
    }
}
