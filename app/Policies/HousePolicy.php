<?php

namespace App\Policies;

use App\Models\House;
use App\Models\User;

class HousePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, House $house): bool
    {
        return $house->users->contains($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, House $house): bool
    {
        return $house->owner_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, House $house): bool
    {
        return $house->owner_id === $user->id;
    }

    /**
     * Determine whether the user can assign model.
     */
    public function set(User $user, House $house): bool
    {
        return $house->users->contains($user);
    }
}
