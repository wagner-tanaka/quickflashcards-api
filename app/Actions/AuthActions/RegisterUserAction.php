<?php

namespace App\Actions\AuthActions;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterUserAction
{
    public function handle(array $data): string
    {
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        return $user->createToken('auth_token')->plainTextToken;
    }
}
