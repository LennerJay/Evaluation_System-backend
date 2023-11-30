<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Questionaire;
use App\Models\Role;
use App\Models\User;
use App\Policies\QuestionairePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Questionaire::class => QuestionairePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

        Gate::define('allow-action',function(User $user){
            return $user->role_id === Role::IS_ADMIN || $user->role_id === Role::IS_STAFF;
        });

    }
}
