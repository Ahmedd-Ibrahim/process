<?php
namespace App\Http\Controllers\Api\V1\Admin;

use App\Models\Role;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {
            if (Auth::attempt($request->only('email', 'password'))) {
                $token = Auth::user()->createToken('auth_token')->plainTextToken;
                return responseJson(['token' => $token, 'data' => new UserResource(Auth::user())]);
            }
            return failedResponseJson(['data' => 'wrong Password']);
        } catch (\Throwable $Throwable) {
            return failedResponseJson(['messagte' => $Throwable->getMessage()]);
        }
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return responseJson(['data' => 'logged out']);
    }

    public function register(UserRequest $request)
    {
        $user = User::create($request->validated());
        $user->roles()->sync(Role::findOrCreate('user'));
        Auth::loginUsingId($user->id);
        $token = Auth::user()->createToken('auth_token')->plainTextToken;
        return responseJson(['token' => $token, 'data' => new UserResource(Auth::user())]);
    }
}
