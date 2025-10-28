<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\App;

class AuthController extends Controller
{
    public function __construct()
    {
        // Aplica middleware 'auth:api' exceto para 'login' e 'register'
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    // 1. Endpoint: /api/login (POST)
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $jwtAuth = App::make('auth')->guard('api');

        if (! $token = $jwtAuth->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    // 2. Endpoint: /api/register (POST)
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $this->make('auth')->guard('api')->login($user);

        return $this->respondWithToken($token);
    }

    // 3. Endpoint: /api/logout (POST, Protegida)
    public function logout()
    {
        App::make('auth')->guard('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    // 4. Endpoint: /api/me (GET, Protegida)
    public function me()
    {
        $user = auth('api')->user();
        return new UserResource($user);
    }

    protected function respondWithToken($token)
    {
        $user = auth('api')->user();
        
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => App::make('auth')->guard('api')->factory()->getTTL() * 60,
            'user' => new UserResource($user)
        ]);
    }
}