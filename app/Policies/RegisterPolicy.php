<?php

namespace App\Policies;

use App\Models\Register;
use App\Models\User;

class RegisterPolicy
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
    public function view(User $user, Register $model): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return auth()->id() !== 1;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Register $model): bool
    {
        return auth()->id() !== 1;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Register $model): bool
    {
        return auth()->id() !== 1;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Register $model): bool
    {
        return auth()->id() !== 1;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Register $model): bool
    {
        return auth()->id() !== 1;
    }
}
