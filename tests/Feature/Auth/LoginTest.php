<?php

namespace Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private string $correctPassword = 'password';

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'password' => bcrypt($this->correctPassword),
        ]);
    }

    public static function userLoginDataProvider(): array
    {
        return [
            'with correct password' => ['password', 200],
            'with incorrect password' => ['wrongPassword', 401],
        ];
    }

    public static function malformedEmailProvider(): array
    {
        return [
            'missing domain' => ['email@'],
            'missing at symbol' => ['email'],
        ];
    }

    /**
     * @dataProvider userLoginDataProvider
     */
    public function testUserLogin(string $password, int $expectedStatus)
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => $this->user->email,
            'password' => $password,
        ]);

        $response->assertStatus($expectedStatus);
    }

    public function testLoginWithInvalidEmail()
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'nonexistent@example.com',
            'password' => $this->correctPassword,
        ]);

        $response->assertStatus(401);
    }

    public function testLoginWithEmptyCredentials()
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => '',
            'password' => '',
        ]);

        $response->assertStatus(422);
    }

    /**
     * @dataProvider malformedEmailProvider
     */
    public function testLoginWithMalformedEmail(string $malformedEmail)
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => $malformedEmail,
            'password' => $this->correctPassword,
        ]);

        $response->assertStatus(422);
    }
}
