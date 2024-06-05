<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\service;
use App\Policies\ServicePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
            // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        service::class => ServicePolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {

        $this->registerPolicies();
        /* define an administrator user role */
        Gate::define('isAdmin', function ($user) {
            return $user->role == 'admin';
        });

        /* define an author user role */
        Gate::define('isLecturer', function ($user) {
            return $user->role == 'lecturer';
        });

        Gate::define('isUser', function ($user) {
            return $user->role == 'user';
        });

        Gate::define('isFreelancer', function ($user) {
            return $user->role == 'freelancer';
        });
    }
}
