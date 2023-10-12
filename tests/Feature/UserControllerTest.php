<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use DatabaseTransactions;

    private $headers = [
        'Accept' => 'application/json',
        'Content-type' => 'application/json',
    ];

    public function test_index()
    {
        $user = User::factory()->create();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getToken(),
        ])->json('GET', route('api.users.index', [
            'filter' => [
                'term' => rand(0, 1) ? $user->name : $user->email,
            ],
            'per_page' => 1,
            'page' => 1,
        ]), $this->headers);
        $response->assertStatus(200);

        $expected = $response->decodeResponseJson()['data'][0];
        $this->assertEquals($user->toArray(), $expected);
    }

    public function test_show()
    {
        $user = User::factory()->create();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getToken(),
        ])->json('GET', route('api.users.show', ['user' => $user->id]), $this->headers);
        $response->assertStatus(200);

        $expected = $response->json();
        $this->assertEquals(['data' => $user->toArray()], $expected);
    }

    public function test_store()
    {
        $user = User::factory()->make()->toArray();
        $user['password'] = 'string';
        $user['password_confirmation'] = 'string';
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getToken(),
        ])->json('POST', route('api.users.store'), $user, $this->headers);
        $response->assertStatus(201);

        $expected = $response->json();
        unset($user['password']);
        unset($user['password_confirmation']);
        unset($user['email_verified_at']);

        $user['updated_at'] = $expected['data']['updated_at'];
        $user['created_at'] = $expected['data']['created_at'];
        $user['id'] = $expected['data']['id'];
        $this->assertEquals(['data' => $user], $expected);
    }

    public function test_update()
    {
        $user = User::factory()->create();
        $updatedUser = User::factory()->make()->toArray();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getToken(),
        ])->json('PUT', route('api.users.update', ['user' => $user->id]), $updatedUser, $this->headers);
        $response->assertStatus(200);

        $expected = $response->json();

        $updatedUser['updated_at'] = $expected['data']['updated_at'];
        $updatedUser['created_at'] = $expected['data']['created_at'];
        $updatedUser['id'] = $expected['data']['id'];
        $this->assertEquals(['data' => $updatedUser], $expected);
    }

    public function test_delete()
    {
        $user = User::factory()->create();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getToken(),
        ])->json('DELETE', route('api.users.delete', ['user' => $user->id]), $this->headers);
        $response->assertStatus(200);
    }
}
