<?php

namespace App\Providers;

use App\Models\Ride;
use App\Models\User;
use App\Models\Vehicle;
use App\Policies\RidePolicy;
use App\Policies\VehiclePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Vehicle::class => VehiclePolicy::class,
        Ride::class => RidePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Define admin gate
        Gate::define('admin', function (User $user) {
            return $user->role === 'admin';
        });
    }
}
