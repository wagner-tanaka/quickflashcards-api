<?php

namespace App\Actions\AuthActions;

use Illuminate\Support\Facades\Auth;

class LoginUserAction
{
    public function handle(string $email, string $password): ?string
    {
        if (!Auth::attempt(compact('email', 'password'))) {
            return null;
        }

        return Auth::user()->createToken('auth_token')->plainTextToken;
    }
}
