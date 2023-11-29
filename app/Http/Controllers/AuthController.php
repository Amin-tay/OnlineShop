<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;

use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\User\app\Models\User;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {

        $request->validated($request->all());

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Credentials do not match!'], 401);
        }


        $user = User::where('email', $request->email)->first();
        $user->tokens()->delete();
        return response()->json([
            'user' => $user,
            'token' => $user->createToken('token')->plainTextToken,
        ]);
    }

    public function register(RegisterRequest $request)
    {
        $request->validated($request->all());

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ])->assignRole('normalUser');


        return response()->json([
            'user' => $user,
            'token' => $user->createToken('token')->plainTextToken,
        ]);
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'You have been logged out!'
        ]);
    }

    public function testAuth()
    {
        return response()->json([
            'message' => 'test Auth is ok'
        ]);
    }

    public function testAuthAdmin()
    {
        return response()->json([
            'message' => 'test Auth Admin is ok'
        ]);
    }
}

