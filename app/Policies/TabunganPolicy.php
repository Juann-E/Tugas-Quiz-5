<?php

namespace App\Policies;

use App\Models\tabungan;
use App\Models\User;

class TabunganPolicy
{
    /**
     * Determine if the user can view any tabungan.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can view the tabungan.
     */
    public function view(User $user, tabungan $tabungan): bool
    {
        return $user->id === $tabungan->user_id;
    }

    /**
     * Determine if the user can create tabungan.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can update the tabungan.
     */
    public function update(User $user, tabungan $tabungan): bool
    {
        return $user->id === $tabungan->user_id;
    }

    /**
     * Determine if the user can delete the tabungan.
     */
    public function delete(User $user, tabungan $tabungan): bool
    {
        return $user->id === $tabungan->user_id;
    }

    /**
     * Determine if the user can restore the tabungan.
     */
    public function restore(User $user, tabungan $tabungan): bool
    {
        return $user->id === $tabungan->user_id;
    }

    /**
     * Determine if the user can permanently delete the tabungan.
     */
    public function forceDelete(User $user, tabungan $tabungan): bool
    {
        return $user->id === $tabungan->user_id;
    }
}
