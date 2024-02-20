<?php

namespace App\Http\Controllers;

use App\Http\Requests\DutyRequest;
use App\Models\Duty;

class DutyController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Duty::class, 'duty');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(["duties" => auth()->user()->duties]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DutyRequest $request)
    {
        $duty = auth()->user()->pickedHouse->duties()->create($request->validated());

        return response()->json(["duty" => $duty]);
    }
    /**
     * Display the specified resource.
     */
    public function show(Duty $duty)
    {
        return response()->json(["duty" => $duty]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DutyRequest $request, Duty $duty)
    {
        $duty->update($request->validated());

        return response()->json(["duty" => $duty]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Duty $duty)
    {
        $duty->delete();

        return response()->json(["duties" => auth()->user()->duties]);
    }
}
