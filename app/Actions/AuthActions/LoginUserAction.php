<?php

namespace App\Actions\AuthActions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class LoginUserAction
{

 /**
  * @throws Exception
  */
 public function handle(string $email, string $password): ?string
    {
        if (!Auth::attempt(compact('email', 'password'))) {
           throw new AuthenticationException('Invalid login credentials');
        }

        return Auth::user()->createToken('auth_token')->plainTextToken;
    }
}
