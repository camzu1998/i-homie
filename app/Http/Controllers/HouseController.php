<?php

namespace App\Http\Controllers;

use App\Http\Requests\HouseRequest;
use App\Http\Requests\UpdateHouseRequest;
use App\Models\House;
use App\Models\User;
use App\Services\HouseService;

class HouseController extends Controller
{
    private HouseService $houseService;

    public function __construct()
    {
        $this->authorizeResource(House::class, 'house');
        $this->houseService = new HouseService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(["houses" => $this->houseService->outputData(auth()->user()->houses), "pickedHouse" => auth()->user()->picked_house_id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HouseRequest $request)
    {
        $house = auth()->user()->ownHouses()->create($request->safe()->only('name'));
        //Attach users to the house
        $usersNames = $request->safe()->only('users')['users'] ?? [];
        $this->houseService->syncUsers($house, $usersNames);
        //Set newly created house as picked house
        //Todo: do this when user has no houses or picked house
        auth()->user()->picked_house_id = $house->id;
        auth()->user()->save();

        return response()->json(["houses" => $this->houseService->outputData(auth()->user()->houses), "pickedHouse" => auth()->user()->picked_house_id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(House $house)
    {
        $users = $house->users->map(function ($user) {
            return [
                'value' => $user->name,
            ];
        })->toArray();

        return response()->json(["house" => $house->load(['users', 'owner']), "users" => $users]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HouseRequest $request, House $house)
    {
        $house->update($request->safe()->only('name'));
        $usersNames = $request->safe()->only('users')['users'] ?? [];
        //Attach users to the house
        $this->houseService->syncUsers($house, $usersNames);

        return response()->json(["houses" => $this->houseService->outputData(auth()->user()->houses), "pickedHouse" => auth()->user()->picked_house_id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(House $house)
    {
        $this->houseService->deleteHouse($house);

        return response()->json(["houses" => $this->houseService->outputData(auth()->user()->houses), "pickedHouse" => auth()->user()->picked_house_id]);
    }
}
