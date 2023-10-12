<?php

namespace App\Actions\AuthActions;

use Illuminate\Support\Facades\Hash;

class UpdateUserPasswordAction
{
    public function handle($user, string $newPassword): void
    {
        $user->password = Hash::make($newPassword);
        $user->save();
    }
}
