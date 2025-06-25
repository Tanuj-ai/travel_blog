<?php

namespace App\Policies;

use App\Models\Trip;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TripPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the trip.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Trip  $trip
     * @return bool
     */
    public function view(User $user, Trip $trip)
    {
        return $user->id === $trip->user_id;
    }

    /**
     * Determine whether the user can update the trip.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Trip  $trip
     * @return bool
     */
    public function update(User $user, Trip $trip)
    {
        return $user->id === $trip->user_id;
    }
}
