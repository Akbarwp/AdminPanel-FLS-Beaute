<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        Gate::define('group_pusat', function(User $user) {
            return $user->id_group === 1;
        });

        Gate::define('group_distributor', function(User $user) {
            return $user->id_group != 1 && $user->user_position != "reseller";
        });

        Gate::define('superadmin_pabrik', function(User $user) {
            return $user->user_position === 'superadmin_pabrik';
        });

        Gate::define('superadmin_pabrik', function(User $user) {
            return $user->user_position === 'superadmin_pabrik';
        });

        Gate::define('admin', function(User $user) {
            return $user->user_position === 'admin';
        });

        Gate::define('cashier_pabrik', function(User $user) {
            return $user->user_position === 'cashier_pabrik';
        });

        Gate::define('accounting_pabrik', function(User $user) {
            return $user->user_position === 'accounting_pabrik';
        });

        Gate::define('superadmin_distributor', function(User $user) {
            return $user->user_position === 'superadmin_distributor';
        });

        Gate::define('cashier_distributor', function(User $user) {
            return $user->user_position === 'cashier_distributor';
        });

        Gate::define('reseller', function(User $user) {
            return $user->user_position === 'reseller';
        });
        
        Gate::define('sales', function(User $user) {
            return $user->user_position === 'sales';
        });
    }
}
