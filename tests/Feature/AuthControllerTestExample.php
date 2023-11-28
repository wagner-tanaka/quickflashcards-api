<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use DatabaseTransactions;

    private $headers = [
        'Accept' => 'application/json',
        'Content-type' => 'application/json',
    ];

    public function test_login()
    {
        $user = User::factory()->create();
        $response = $this->json('POST', route('api.auth.login', [
            'email' => $user->email,
            'password' => 'password',
        ]), $this->headers);
        $response->assertStatus(200);
    }

    public function test_logout()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getToken(),
        ])->json('POST', route('api.auth.logout'), $this->headers);
        $response->assertStatus(200);
    }

    public function test_refresh()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getToken(),
        ])->json('POST', route('api.auth.refresh'), $this->headers);
        $response->assertStatus(200);
    }
}
