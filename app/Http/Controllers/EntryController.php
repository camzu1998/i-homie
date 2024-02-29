<?php

namespace App\Http\Controllers;

use App\Http\Requests\EntryRequest;
use App\Models\Entry;

class EntryController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Entry::class, 'entry');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['entries' => auth()->user()->pickedHouse->entries]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EntryRequest $request)
    {
        auth()->user()->pickedHouse->entries()->create($request->validated());

        return response()->json(['entries' => auth()->user()->pickedHouse->entries]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Entry $entry)
    {
        return response()->json(['entry' => $entry]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EntryRequest $request, Entry $entry)
    {
        $entry->update($request->validated());

        return response()->json(['entries' => auth()->user()->pickedHouse->entries]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entry $entry)
    {
        $entry->delete();

        return response()->json(['entries' => auth()->user()->pickedHouse->entries]);
    }
}
