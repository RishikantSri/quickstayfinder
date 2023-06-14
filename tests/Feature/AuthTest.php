<?php

namespace Tests\Feature;

use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_fails_with_admin_role()
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role_id' => Role::ROLE_ADMINISTRATOR
        ]);

        // dd($response->json());

        $response->assertStatus(422);
    }

    public function test_registration_succeeds_with_owner_role()
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Propert Owner 1 ',
            'email' => 'pw1@email.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role_id' => Role::ROLE_OWNER
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'access_token',
        ]);
    }

    public function test_registration_succeeds_with_user_role()
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'User 1',
            'email' => 'user_1@email.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role_id' => Role::ROLE_USER
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'access_token',
        ]);
    }
}
