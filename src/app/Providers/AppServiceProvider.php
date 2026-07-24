<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        // Gate untuk menu Admin only
        Gate::define('manage-users', function ($user) {
            return $user->role === 'Admin';
        });

        Gate::define('view-audit-trail', function ($user) {
            return $user->role === 'Admin';
        });
    }
}
