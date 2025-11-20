<?php

namespace App\Policies;

use App\Models\Ride;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RidePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'driver';
    }

    public function view(User $user, Ride $ride): bool
    {
        return $user->id === $ride->user_id;
    }

    public function create(User $user): bool
    {
        return $user->role === 'driver';
    }

    public function update(User $user, Ride $ride): bool
    {
        return $user->id === $ride->user_id;
    }

    public function delete(User $user, Ride $ride): bool
    {
        return $user->id === $ride->user_id;
    }

    public function restore(User $user, Ride $ride): bool
    {
        return $user->id === $ride->user_id;
    }

    public function forceDelete(User $user, Ride $ride): bool
    {
        return $user->id === $ride->user_id;
    }
}
