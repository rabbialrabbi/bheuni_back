<?php

namespace App\Providers;

use App\Models\Lead;
use App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
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
        $this->registerGates();
    }

    public function registerGates()
    {

        foreach ($this->getPermissions() as $permission) {
            Gate::define(strtolower($permission->slug), function ($user) use ($permission) {
                return $user->hasRole($permission->roles);
            });
        }

        Gate::define('update-lead-status', function ($user,Lead $lead) {
            return $user->id == $lead->counselor_id;
        });
    }

    /**
     * Get all permissions with role.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPermissions()
    {
        if (Schema::hasTable('roles') && Schema::hasTable('permissions')) {
            return Permission::with('roles')->get();
        } else {
            return [];
        }
    }
}
