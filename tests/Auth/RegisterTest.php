<?php

namespace Tests\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public static function invalidEmailProvider(): array
    {
        return [
            'missing domain' => ['email@'],
            'missing at symbol' => ['email'],
        ];
    }

    public static function invalidPasswordProvider(): array
    {
        return [
            'too short' => ['short'],
            'only numbers' => ['12345678'],
        ];
    }

    /** @test */
    public function user_can_register_with_valid_credentials()
    {
        $userData = User::factory()->make([
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->toArray();

        $response = $this->postJson('/api/auth/register', $userData);
        $response->assertStatus(200);
    }

    /**
     * @dataProvider invalidEmailProvider
     * @test
     */
    public function registration_fails_with_invalid_email($email)
    {
        $userData = User::factory()->make([
            'email' => $email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->toArray();

        $response = $this->postJson('/api/auth/register', $userData);
        $response->assertStatus(422);
    }

    /**
     * @dataProvider invalidPasswordProvider
     * @test
     */
    public function registration_fails_with_invalid_password($password)
    {
        $userData = User::factory()->make([
            'password' => $password,
            'password_confirmation' => $password,
        ])->toArray();

        $response = $this->postJson('/api/auth/register', $userData);
        $response->assertStatus(422);
    }

    /** @test */
    public function user_record_is_created_after_successful_registration()
    {
        $userData = User::factory()->make([
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->toArray();

        $this->postJson('/api/auth/register', $userData);
        $this->assertDatabaseHas('users', [
            'email' => $userData['email'],
        ]);
    }
}
