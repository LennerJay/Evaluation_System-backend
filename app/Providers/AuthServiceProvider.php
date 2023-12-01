<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Questionaire;
use App\Models\Role;
use App\Models\User;
use App\Models\UserInfo;
use App\Policies\QuestionairePolicy;
use App\Policies\UserInfoPolicy;
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
        UserInfo::class => UserInfoPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

        Gate::define('allow-action',function(User $user){
            return $user->role_id === Role::IS_ADMIN || $user->role_id === Role::IS_STAFF;
        });

        Gate::define('change-password',function($user){
            return $user->id_number === auth()->user()->id_number;
        });

    }
}
