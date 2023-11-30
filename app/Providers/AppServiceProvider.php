<?php

namespace App\Providers;


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






    }
}
