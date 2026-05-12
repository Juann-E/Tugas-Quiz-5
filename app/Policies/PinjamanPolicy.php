<?php

namespace App\Policies;

use App\Models\pinjaman;
use App\Models\User;

class PinjamanPolicy
{
    /**
     * Determine if the user can view any pinjaman.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can view the pinjaman.
     */
    public function view(User $user, pinjaman $pinjaman): bool
    {
        return $user->id === $pinjaman->user_id;
    }

    /**
     * Determine if the user can create pinjaman.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can update the pinjaman.
     */
    public function update(User $user, pinjaman $pinjaman): bool
    {
        return $user->id === $pinjaman->user_id;
    }

    /**
     * Determine if the user can delete the pinjaman.
     */
    public function delete(User $user, pinjaman $pinjaman): bool
    {
        return $user->id === $pinjaman->user_id && $pinjaman->status === 'menunggu';
    }

    /**
     * Determine if the user can restore the pinjaman.
     */
    public function restore(User $user, pinjaman $pinjaman): bool
    {
        return $user->id === $pinjaman->user_id;
    }

    /**
     * Determine if the user can permanently delete the pinjaman.
     */
    public function forceDelete(User $user, pinjaman $pinjaman): bool
    {
        return $user->id === $pinjaman->user_id;
    }
}
