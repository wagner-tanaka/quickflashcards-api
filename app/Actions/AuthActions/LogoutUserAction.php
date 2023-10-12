<?php

namespace App\Actions\AuthActions;

class LogoutUserAction
{
    public function handle($user): void
    {
        $user->currentAccessToken()->delete();
    }
}
