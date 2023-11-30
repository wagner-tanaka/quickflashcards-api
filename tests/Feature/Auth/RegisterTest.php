<?php

namespace Feature\Auth;

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

    public function testUserCanRegister()
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
     */
    public function testRegistrationWithInvalidEmail($email)
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
     */
    public function testRegistrationWithInvalidPassword($password)
    {
        $userData = User::factory()->make([
            'password' => $password,
            'password_confirmation' => $password,
        ])->toArray();

        $response = $this->postJson('/api/auth/register', $userData);
        $response->assertStatus(422);
    }

    public function testUserIsInDatabaseAfterSuccessfulRegistration()
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
