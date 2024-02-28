<?php

namespace App\Http\Controllers;

use App\Http\Requests\HouseRequest;
use App\Models\House;
use App\Services\HouseService;

class HouseController extends Controller
{
    private HouseService $houseService;

    public function __construct(
        HouseService $houseService
    )
    {
        $this->authorizeResource(House::class, 'house');
        $this->houseService = $houseService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(["houses" => $this->houseService->setUser()->outputData(), "pickedHouse" => auth()->user()->picked_house_id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HouseRequest $request)
    {
        $this->houseService = $this->houseService->setUser()->create($request->safe()->only('name'), $request->safe()->only('users')['users'] ?? []);

        return response()->json(["houses" => $this->houseService->outputData(), "pickedHouse" => auth()->user()->picked_house_id]);
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
        $this->houseService->setUser()->setHouse($house);
        $house->update($request->safe()->only('name'));
        //Attach users to the house
        $usersNames = $request->safe()->only('users')['users'] ?? [];
        $this->houseService->syncUsers($usersNames);

        return response()->json(["houses" => $this->houseService->outputData(), "pickedHouse" => auth()->user()->picked_house_id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(House $house)
    {
        $this->houseService->setUser()->setHouse($house);
        $this->houseService->deleteHouse();

        return response()->json(["houses" => $this->houseService->outputData(), "pickedHouse" => auth()->user()->picked_house_id]);
    }

    /**
     * Set the specified resource to auth user.
     */
    public function set(House $house)
    {
        $this->authorize('set', [$house, auth()->user()]);
        $this->houseService->setUser()->setHouse($house);
        $this->houseService->setPickedHouse();

        return response()->json(["houses" => $this->houseService->outputData(), "pickedHouse" => auth()->user()->picked_house_id]);
    }
}
