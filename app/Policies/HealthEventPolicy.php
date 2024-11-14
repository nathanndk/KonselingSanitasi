<?php

namespace App\Policies;

use App\Models\HealthEvent;
use App\Models\User;

class HealthEventPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->hasPermissionTo('View Jadwal Acara')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, HealthEvent $healthEvent): bool
    {
        if ($user->hasPermissionTo('View Jadwal Acara')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->hasPermissionTo('Create Jadwal Acara')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, HealthEvent $healthEvent): bool
    {
        if ($user->hasPermissionTo('Edit Jadwal Acara')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, HealthEvent $healthEvent): bool
    {
        if ($user->hasPermissionTo('Delete Jadwal Acara')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, HealthEvent $healthEvent): bool
    {
        if ($user->hasPermissionTo('Edit Jadwal Acara')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, HealthEvent $healthEvent): bool
    {
        if ($user->hasPermissionTo('Delete Jadwal Acara')) {
            return true;
        }
        return false;
    }
}
