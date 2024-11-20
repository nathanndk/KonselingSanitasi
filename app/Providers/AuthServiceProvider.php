<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\HealthEvent;
use App\Models\HousingSurvey;
use App\Models\Patient;
use App\Models\PDAM;
use App\Models\Permission;
use App\Models\Role;
use App\Models\SanitationCondition;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;
use App\Policies\HealthEventPolicy;
use App\Policies\HousingSurveyPolicy;
use App\Policies\PatientPolicy;
use App\Policies\PdamPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use App\Policies\SanitationConditionPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        HealthEvent::class => HealthEventPolicy::class,
        HousingSurvey::class => HousingSurveyPolicy::class,
        Patient::class => PatientPolicy::class,
        PDAM::class => PdamPolicy::class,
        Permission::class => PermissionPolicy::class,
        Role::class => RolePolicy::class,
        SanitationCondition::class => SanitationConditionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Admin') ? true : null;
        });
    }
}
