<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function auth(LoginRequest $request)
    {
        $request->validated();

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            //Todo: Check remember me
            //Todo: Process api_token
//            $user->api_token = Str::random(60);
//            $user->save();
            return response()->json(["user" => $user]);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    public function store(RegisterRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);
        return response()->json(["status" => "success"]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(["status" => "success"]);
    }
}
