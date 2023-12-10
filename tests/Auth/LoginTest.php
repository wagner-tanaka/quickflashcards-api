<?php

namespace Tests\Auth;

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
     * @test
     */
    public function user_can_login_with_various_credentials(string $password, int $expectedStatus)
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => $this->user->email,
            'password' => $password,
        ]);

        $response->assertStatus($expectedStatus);
    }

    /** @test */
    public function user_cannot_login_with_invalid_email()
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'nonexistent@example.com',
            'password' => $this->correctPassword,
        ]);

        $response->assertStatus(401);
    }

    /** @test */
    public function user_cannot_login_with_empty_credentials()
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => '',
            'password' => '',
        ]);

        $response->assertStatus(422);
    }

    /**
     * @dataProvider malformedEmailProvider
     * @test
     */
    public function user_cannot_login_with_malformed_email(string $malformedEmail)
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => $malformedEmail,
            'password' => $this->correctPassword,
        ]);

        $response->assertStatus(422);
    }
}
