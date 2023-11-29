<?php

namespace Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testLoginSuccess(): void
    {
        // create user
        $user = User::factory()->create();

        // login
        $response = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        // assert response status and structure
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
                'token_type',
            ]);
    }
}
