<?php

namespace App\Http\Controllers;

use App\Actions\AuthActions\LoginUserAction;
use App\Actions\AuthActions\LogoutUserAction;
use App\Actions\AuthActions\RegisterUserAction;
use App\Actions\AuthActions\UpdateUserPasswordAction;
use App\Http\Requests\Auth\LoginAuthRequest;
use App\Http\Requests\Auth\RegisterAuthRequest;
use App\Http\Requests\Auth\UpdateAuthRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterAuthRequest $request, RegisterUserAction $action): JsonResponse
    {
        $token = $action->handle($request->validated());

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * @throws Exception
     */
    public function login(LoginAuthRequest $request, LoginUserAction $action): JsonResponse
    {
        $token = $action->handle($request->email, $request->password);

        if (!$token) {
            return response()->json(['message' => 'Invalid login credentials'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request, LogoutUserAction $action): void
    {
        $action->handle($request->user());
    }

    public function updatePassword(UpdateAuthRequest $request, UpdateUserPasswordAction $action): JsonResponse
    {
        if (!Hash::check($request->current_password, $request->user()->password)) {
            return response()->json(['message' => 'Current password does not match'], 400);
        }

        $action->handle($request->user(), $request->new_password);

        return response()->json(['message' => 'Password updated successfully']);
    }
}
