<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }

        Gate::define('access-admin-manager-program', function ($user) {
            return in_array($user->role, ['admin', 'manager', 'program']);
        });
        Gate::define('access-admin-manager', function ($user) {
            return in_array($user->role, ['admin', 'manager']);
        });
        Gate::define('access-admin-program', function ($user) {
            return in_array($user->role, ['admin', 'program']);
        });
        Gate::define('access-admin', function ($user) {
            return in_array($user->role, ['admin']);
        });
        Gate::define('access-manager', function ($user) {
            return in_array($user->role, ['manager']);
        });
        Gate::define('access-program', function ($user) {
            return in_array($user->role, ['program']);
        });
        Gate::define('access-fundraising', function ($user) {
            return in_array($user->role, ['fundraising']);
        });
    }
}
