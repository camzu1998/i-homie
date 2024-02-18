<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomRequest;
use App\Models\Room;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = auth()->user()->pickedHouse->rooms;

        return response()->json(['rooms' => $rooms]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoomRequest $request)
    {
        auth()->user()->pickedHouse->rooms()->create($request->validated());
        $rooms = auth()->user()->pickedHouse->rooms;

        return response()->json(['rooms' => $rooms]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        return response()->json(['room' => $room]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoomRequest $request, Room $room)
    {
        $room->update($request->validated());
        $rooms = auth()->user()->pickedHouse->rooms;

        return response()->json(['rooms' => $rooms]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room->delete();
        $rooms = auth()->user()->pickedHouse->rooms;

        return response()->json(['rooms' => $rooms]);
    }
}
