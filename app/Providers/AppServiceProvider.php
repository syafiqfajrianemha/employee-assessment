<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        Gate::define('access-admin-manager-program', function ($user) {
            return in_array($user->role, ['admin', 'manager', 'program']);
        });
        Gate::define('access-admin-manager', function ($user) {
            return in_array($user->role, ['admin', 'manager']);
        });
        Gate::define('access-admin', function ($user) {
            return in_array($user->role, ['admin']);
        });
    }
}
