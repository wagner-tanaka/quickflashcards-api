<?php

namespace Auth\UpdatePassword;

use App\Actions\AuthActions\UpdateUserPasswordAction;
use App\Models\User;
use Error;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use TypeError;

class UpdatePasswordActionTest extends TestCase
{
    use RefreshDatabase;

    protected UpdateUserPasswordAction $action;

    protected function setUp(): void
    {
        parent::setUp();
        $this->action = new UpdateUserPasswordAction();
    }

    /** @test */
    public function it_updates_user_password()
    {
        $user = User::factory()->create(['password' => Hash::make('oldPassword')]);

        $this->action->handle($user, 'newPassword');

        $this->assertTrue(Hash::check('newPassword', $user->fresh()->password));
    }

    /**
     * @dataProvider invalidUserDataProvider
     * @test
     */
    public function it_fails_to_update_password_with_invalid_data($user, $password, $expectedException)
    {
        $this->expectException($expectedException);

        $this->action->handle($user, $password);
    }

    public static function invalidUserDataProvider(): array
    {
        return [
            'null_user' => [null, 'newPassword', Error::class],
            'invalid_password_format' => [User::factory()->make(), ['invalid', 'password', 'format'], TypeError::class],
        ];
    }
}
