<?php

namespace Feature\Auth\UpdatePassword;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UpdatePasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(['password' => Hash::make('oldPassword')]);
    }

    /** @test */
    public function it_fails_to_update_password_with_incorrect_current_password()
    {
        $response = $this->actingAs($this->user)->postJson(route('api.auth.update-password'), [
            'current_password' => 'wrongPassword',
            'new_password' => 'newPassword',
            'new_password_confirmation' => 'newPassword',
        ]);

        $response->assertStatus(400)
            ->assertJson(['message' => 'Current password does not match']);
    }

    /** @test */
    public function it_updates_password_successfully()
    {
        $response = $this->actingAs($this->user)->postJson(route('api.auth.update-password'), [
            'current_password' => 'oldPassword',
            'new_password' => 'newPassword',
            'new_password_confirmation' => 'newPassword',
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Password updated successfully']);

        $this->assertTrue(Hash::check('newPassword', $this->user->fresh()->password));
    }

    /** @test */
    public function it_fails_to_update_password_with_invalid_input()
    {
        $response = $this->actingAs($this->user)->postJson(route('api.auth.update-password'), [
            'current_password' => 'oldPassword',
            // 'new_password' => 'newPassword', // Intentionally omitted to test invalid input
            'new_password_confirmation' => 'newPassword',
        ]);

        $response->assertStatus(422);
    }

    /** @test */
    public function it_fails_for_unauthenticated_user()
    {
        $response = $this->postJson(route('api.auth.update-password'), [
            'current_password' => 'oldPassword',
            'new_password' => 'newPassword',
            'new_password_confirmation' => 'newPassword',
        ]);

        $response->assertStatus(401);
    }

    /** @test */
    public function it_requires_password_confirmation()
    {
        $response = $this->actingAs($this->user)->postJson(route('api.auth.update-password'), [
            'current_password' => 'oldPassword',
            'new_password' => 'newPassword',
            'new_password_confirmation' => 'mismatchedPassword',
        ]);

        $response->assertStatus(422);
    }
}
