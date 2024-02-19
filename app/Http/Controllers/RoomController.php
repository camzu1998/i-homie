<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomRequest;
use App\Models\Room;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Room::class, 'room');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = auth()->user()->pickedHouse->rooms;
        $users = auth()->user()->pickedHouse->users->map(function ($user) {
            return [
                'value' => $user->id,
                'text' => $user->name,
            ];
        });
        $users[] = ['value' => null, 'text' => 'Dont assign homie to room'];

        return response()->json(['rooms' => $rooms, 'users' => $users]);
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
