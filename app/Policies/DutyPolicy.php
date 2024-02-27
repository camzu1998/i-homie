<?php

namespace App\Policies;

use App\Models\Duty;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DutyPolicy
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
    public function view(User $user, Duty $duty): bool
    {
        return $duty->house->users->contains($user);
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
    public function update(User $user, Duty $duty): bool
    {
        return $duty->house->users->contains($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Duty $duty): bool
    {
        return $duty->house->users->contains($user);
    }
}
