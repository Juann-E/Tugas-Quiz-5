<?php

namespace App\Policies;

use App\Models\simpanan;
use App\Models\User;

class SimpananPolicy
{
    /**
     * Determine if the user can view any simpanan.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can view the simpanan.
     */
    public function view(User $user, simpanan $simpanan): bool
    {
        return $user->id === $simpanan->user_id;
    }

    /**
     * Determine if the user can create simpanan.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can update the simpanan.
     */
    public function update(User $user, simpanan $simpanan): bool
    {
        return $user->id === $simpanan->user_id;
    }

    /**
     * Determine if the user can delete the simpanan.
     */
    public function delete(User $user, simpanan $simpanan): bool
    {
        return $user->id === $simpanan->user_id;
    }

    /**
     * Determine if the user can restore the simpanan.
     */
    public function restore(User $user, simpanan $simpanan): bool
    {
        return $user->id === $simpanan->user_id;
    }

    /**
     * Determine if the user can permanently delete the simpanan.
     */
    public function forceDelete(User $user, simpanan $simpanan): bool
    {
        return $user->id === $simpanan->user_id;
    }
}
