<?php

namespace App\Providers;

use App\Models\Permission;
use Gate;
use Illuminate\Support\ServiceProvider;

class PermissionsServiceProvider extends ServiceProvider
{



    public function boot()
    {
        Permission::get()->map(function ($permission){
            Gate::define($permission->name, function($user) use ($permission){
                return $user->hasPermissionTo($permission);
            });
        });
    }
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */

}
