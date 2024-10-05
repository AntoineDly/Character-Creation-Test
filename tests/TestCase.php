<?php

declare(strict_types=1);

namespace Tests;

use DateTime;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Passport\ClientRepository;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createClient();
    }

    private function createClient() : void
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
            'client_id'  => $clientId,
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);
    }
}
