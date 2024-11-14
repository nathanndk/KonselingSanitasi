<?php

namespace App\Policies;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PatientPolicy
{public function viewAny(User $user): bool
    {
        if ($user->hasPermissionTo('View Pasien')) {
            return true;
        }
        return false;
    }

    public function view(User $user, Patient $patient): bool
    {
        if ($user->hasPermissionTo('View Pasien')) {
            return true;
        }
        return false;
    }

    public function create(User $user): bool
    {
        if ($user->hasPermissionTo('Create Pasien')) {
            return true;
        }
        return false;
    }

    public function update(User $user, Patient $patient): bool
    {
        if ($user->hasPermissionTo('Edit Pasien')) {
            return true;
        }
        return false;
    }

    public function delete(User $user, Patient $patient): bool
    {
        if ($user->hasPermissionTo('Delete Pasien')) {
            return true;
        }
        return false;
    }

    public function restore(User $user, Patient $patient): bool
    {
        if ($user->hasPermissionTo('Edit Pasien')) {
            return true;
        }
        return false;
    }

    public function forceDelete(User $user, Patient $patient): bool
    {
        if ($user->hasPermissionTo('Delete Pasien')) {
            return true;
        }
        return false;
    }

}
