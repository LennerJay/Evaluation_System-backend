<?php

namespace App\Providers;


use App\Models\User;
use App\Models\Questionaire;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\Gate;
use App\Observers\QuestionaireObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();
        Relation::morphMap([
            'evaluatee' =>'App\Models\Evaluatee',
            'user'=> 'App\Models\User',
        ]);


        Gate::define('allow-action',function(User $user){
            return $user->role_id === 2 || $user->role_id === 3;
        });


    }
}
