<?php

namespace App\Policies;

use App\Models\Pdam;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PdamPolicy
{
    public function viewAny(User $user): bool
    {
        if ($user->hasRole('Kader') || $user->hasRole('Petugas')) {
            return true; // Izinkan akses agar bisa difilter di query Filament
        }

        if ($user->hasPermissionTo('View PDAM')) {
            return true;
        }

        return false;
    }


    public function view(User $user, Pdam $pdam): bool
    {
        // Hanya Kader atau Petugas yang dapat melihat PDAM yang mereka buat sendiri
        if (($user->hasRole('Kader') || $user->hasRole('Petugas')) && $user->id === $pdam->user_id) {
            return true;
        }

        // Admin atau role lain dengan izin khusus bisa melihat semua data
        if ($user->hasPermissionTo('View PDAM')) {
            return true;
        }

        return false;
    }

    public function create(User $user): bool
    {
        if ($user->hasPermissionTo('Create PDAM')) {
            return true;
        }
        return false;
    }

    public function update(User $user, Pdam $pdam): bool
    {
        if ($user->hasPermissionTo('Edit PDAM')) {
            return true;
        }
        return false;
    }

    public function delete(User $user, Pdam $pdam): bool
    {
        if ($user->hasPermissionTo('Delete PDAM')) {
            return true;
        }
        return false;
    }

    public function restore(User $user, Pdam $pdam): bool
    {
        if ($user->hasPermissionTo('Edit PDAM')) {
            return true;
        }
        return false;
    }

    public function forceDelete(User $user, Pdam $pdam): bool
    {
        if ($user->hasPermissionTo('Delete PDAM')) {
            return true;
        }
        return false;
    }

}
