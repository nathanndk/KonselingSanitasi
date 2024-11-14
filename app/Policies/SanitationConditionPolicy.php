<?php

namespace App\Policies;

use App\Models\SanitationCondition;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SanitationConditionPolicy
{
    public function viewAny(User $user): bool
    {
        if ($user->hasPermissionTo('View Konseling Sanitasi')) {
            return true;
        }
        return false;
    }

    public function view(User $user, SanitationCondition $sanitationCondition): bool
    {
        if ($user->hasPermissionTo('View Konseling Sanitasi')) {
            return true;
        }
        return false;
    }

    public function create(User $user): bool
    {
        if ($user->hasPermissionTo('Create Konseling Sanitasi')) {
            return true;
        }
        return false;
    }

    public function update(User $user, SanitationCondition $sanitationCondition): bool
    {
        if ($user->hasPermissionTo('Edit Konseling Sanitasi')) {
            return true;
        }
        return false;
    }

    public function delete(User $user, SanitationCondition $sanitationCondition): bool
    {
        if ($user->hasPermissionTo('Delete Konseling Sanitasi')) {
            return true;
        }
        return false;
    }

    public function restore(User $user, SanitationCondition $sanitationCondition): bool
    {
        if ($user->hasPermissionTo('Edit Konseling Sanitasi')) {
            return true;
        }
        return false;
    }

    public function forceDelete(User $user, SanitationCondition $sanitationCondition): bool
    {
        if ($user->hasPermissionTo('Delete Konseling Sanitasi')) {
            return true;
        }
        return false;
    }
}
