<?php

namespace App\Http\Controllers;

use App\Events\UserLoggedIn;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            event(new UserLoggedIn($user));
            return response()->json(["user" => $user]);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);
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
