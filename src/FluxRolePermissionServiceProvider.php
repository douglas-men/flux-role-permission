<?php

namespace Doc88\FluxRolePermission;

use Illuminate\Support\ServiceProvider;

class FluxRolePermissionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    public function register()
    {
    }
}
