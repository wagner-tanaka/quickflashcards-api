<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanRegister()
    {
        // create user data
        $userData = User::factory()->make([
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->toArray();

        // perform the request request
        $response = $this->postJson('/api/auth/register', $userData);

        // assertions
        $response
            ->assertStatus(200)
            ->assertJson([
                'token_type' => 'Bearer',
            ]);

        // assert user was created
        $this->assertDatabaseHas('users', [
            'email' => $userData['email'],
        ]);

        // assert user can authenticate
        $user = User::where('email', $userData['email'])->first();
        $this->assertNotNull($user->tokens->first());
    }
}
