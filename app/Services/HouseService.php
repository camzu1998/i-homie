<?php

namespace App\Services;

use App\Models\House;
use App\Models\User;

class HouseService
{
    private User $user;
    private House $house;

    public function setHouse(House $house): self
    {
        $this->house = $house;

        return $this;
    }

    public function setUser(User $user = null): self
    {
        $this->user = $user ?? auth()->user();

        return $this;
    }

    public function getHouse(): House
    {
        return $this->house;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function create(array $data, array $usersNames = []): self
    {
        $this->house = $this->user->ownHouses()->create($data);
        $this->syncUsers($usersNames);

        //Todo: do this when user has no houses or picked house
        $this->setPickedHouse();

        return $this;
    }

    public function outputData(): array
    {
        $output = [];
        foreach ($this->user->houses as $house) {
            $output[] = [
                'id' => $house->id,
                'name' => $house->name,
                'owner' => $house->owner->name,
                'users' => $house->users->map(function ($user) {
                    return [
                        'value' => $user->name,
                    ];
                })->toArray(),
            ];
        }

        return $output;
    }

    public function syncUsers(array $usersNames = []): self
    {
        $users = User::whereIn('name', $usersNames)->get('id')->pluck('id')->toArray();
        $this->house->users()->sync($users + [$this->user->id => ['status' => 'accepted']]);

        return $this;
    }

    public function setPickedHouse(): self
    {
        $this->user->picked_house_id = $this->house->id;
        $this->user->save();

        return $this;
    }

    public function deleteHouse(): self
    {
        User::where('picked_house_id', $this->house->id)->update(['picked_house_id' => null]);
        $this->house->users()->detach();
        $this->house->delete();

        return $this;
    }
}
