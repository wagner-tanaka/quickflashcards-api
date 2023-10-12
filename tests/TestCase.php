<?php

namespace Tests;

use App\Models\User;
use App\Services\AuthService;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function getToken(): string
    {
        $authService = new AuthService();
        $password = 'password';
        $user = User::factory()->create();
        $accessToken = $authService->login($user->email, $password)['access_token'];
        return $accessToken;
    }
}
