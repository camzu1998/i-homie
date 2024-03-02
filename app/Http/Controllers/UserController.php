<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->validated());
        return response()->json(["user" => $user]);
    }

    public function check()
    {
        return response()->json(["isLogged" => auth()->check()]);
    }
}
