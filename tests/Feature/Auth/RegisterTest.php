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
        $response = $this->postJson('/api/auth/register', [
            'first_name' => 'Johnny',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'token_type' => 'Bearer',
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
        ]);

        $user = User::where('email', 'john@example.com')->first();
        $this->assertNotNull($user->tokens->first());
    }
}
