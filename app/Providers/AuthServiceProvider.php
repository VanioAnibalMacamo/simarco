<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \App\Models\User::class => \App\Policies\UserPolicy::class,
    ];


    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('update', function ($user, $model) {
            return $user->hasPermissionTo('update', $model);
        });

        Gate::define('delete', function ($user, $model) {
            return $user->hasPermissionTo('delete', $model);
        });

        Gate::define('create', function ($user) {
            return $user->hasPermissionTo('create', App\Models\User::class);
        });
    }
}
