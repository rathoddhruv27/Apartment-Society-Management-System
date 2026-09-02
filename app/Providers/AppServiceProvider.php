<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
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
        // Master Admin bypass: automatically grants all permissions to master-admin
        Gate::before(function ($user, $ability) {
            if (method_exists($user, 'isMasterAdmin') && $user->isMasterAdmin()) {
                return true;
            }
            return null;
        });

        // Dynamic Gate definition based on user permissions
        Gate::after(function ($user, $ability, $result) {
            if ($result !== null) {
                return $result;
            }

            if (method_exists($user, 'hasPermission')) {
                return $user->hasPermission($ability);
            }

            return false;
        });

        // Blade Directive: @role('admin') ... @endrole
        Blade::directive('role', function ($expression) {
            return "<?php if (auth()->check() && auth()->user()->hasRole({$expression})): ?>";
        });

        Blade::directive('endrole', function () {
            return "<?php endif; ?>";
        });

        // Blade Directive: @permission('manage-users') ... @endpermission
        Blade::directive('permission', function ($expression) {
            return "<?php if (auth()->check() && auth()->user()->hasPermission({$expression})): ?>";
        });

        Blade::directive('endpermission', function () {
            return "<?php endif; ?>";
        });
    }
}
