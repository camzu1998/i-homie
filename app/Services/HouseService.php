<?php

namespace App\Services;

use App\Models\House;
use App\Models\User;

class HouseService
{
    public function outputData($houses): array
    {
        $output = [];
        foreach ($houses as $house) {
            $output[] = [
                'id' => $house->id,
                'name' => $house->name,
                'owner' => $house->owner->name,
                'users' => $house->users->pluck('name')->toArray(),
            ];
        }

        return $output;
    }

    public function syncUsers(House $house, array $usersNames = []): void
    {
        $users = User::whereIn('name', $usersNames)->get('id')->pluck('id')->toArray();
        $house->users()->sync($users + [auth()->id()]);
    }

    public function setPickedHouse(House $house): void
    {
        auth()->user()->picked_house_id = $house->id;
        auth()->user()->save();
    }

    public function deleteHouse(House $house): void
    {
        User::where('picked_house_id', $house->id)->update(['picked_house_id' => null]);
        $house->users()->detach();
        $house->delete();
    }
}
