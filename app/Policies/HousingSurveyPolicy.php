<?php

namespace App\Policies;

use App\Models\HousingSurvey;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class HousingSurveyPolicy
{
    public function viewAny(User $user): bool
    {
        if ($user->hasPermissionTo('View Rumah Sehat')) {
            return true;
        }
        return false;
    }

    public function view(User $user, HousingSurvey $housingSurvey): bool
    {
        if ($user->hasPermissionTo('View Rumah Sehat')) {
            return true;
        }
        return false;
    }

    public function create(User $user): bool
    {
        if ($user->hasPermissionTo('Create Rumah Sehat')) {
            return true;
        }
        return false;
    }

    public function update(User $user, HousingSurvey $housingSurvey): bool
    {
        if ($user->hasPermissionTo('Edit Rumah Sehat')) {
            return true;
        }
        return false;
    }

    public function delete(User $user, HousingSurvey $housingSurvey): bool
    {
        if ($user->hasPermissionTo('Delete Rumah Sehat')) {
            return true;
        }
        return false;
    }

    public function restore(User $user, HousingSurvey $housingSurvey): bool
    {
        if ($user->hasPermissionTo('Edit Rumah Sehat')) {
            return true;
        }
        return false;
    }

    public function forceDelete(User $user, HousingSurvey $housingSurvey): bool
    {
        if ($user->hasPermissionTo('Delete Rumah Sehat')) {
            return true;
        }
        return false;
    }

}
