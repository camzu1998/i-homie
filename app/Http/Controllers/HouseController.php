<?php

namespace App\Http\Controllers;

use App\Http\Requests\HouseRequest;
use App\Http\Requests\UpdateHouseRequest;
use App\Models\House;
use App\Models\User;

class HouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HouseRequest $request)
    {
        $house = auth()->user()->ownHouses()->create($request->safe()->only('name'));
        $usersNames = $request->safe()->only('users');
        $users = User::whereIn('name', $usersNames)->get('id')->pluck('id')->toArray();
        $house->users()->sync($users + [auth()->id()]);

        return response()->json($house);
    }

    /**
     * Display the specified resource.
     */
    public function show(House $house)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(House $house)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HouseRequest $request, House $house)
    {
        $house->update($request->safe()->only('name'));
        $usersNames = $request->safe()->only('users');
        $users = User::whereIn('name', $usersNames)->get('id')->pluck('id')->toArray();
        $house->users()->sync($users + [auth()->id()]);

        return response()->json($house);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(House $house)
    {
        //
    }
}
