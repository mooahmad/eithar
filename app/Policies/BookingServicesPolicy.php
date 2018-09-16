<?php

namespace App\Policies;

use App\User;
use App\Models\ServiceBooking;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookingServicesPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the service meetings.
     *
     * @param  \App\User  $user
     * @param  \App\Models\ServiceBooking  $serviceBooking
     * @return mixed
     */
    public function view(User $user, ServiceBooking $serviceBooking)
    {
        return true;
    }

    /**
     * Determine whether the user can create service bookings.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the service meetings.
     *
     * @param  \App\User  $user
     * @param  \App\Models\ServiceBooking  $serviceBooking
     * @return mixed
     */
    public function update(User $user, ServiceBooking $serviceBooking)
    {
        //
    }

    /**
     * Determine whether the user can delete the service meetings.
     *
     * @param  \App\User  $user
     * @param  \App\Models\ServiceBooking  $serviceBooking
     * @return mixed
     */
    public function delete(User $user, ServiceBooking $serviceBooking)
    {
        //
    }

    /**
     * Determine whether the user can restore the service meetings.
     *
     * @param  \App\User  $user
     * @param  \App\Models\ServiceBooking  $serviceBooking
     * @return mixed
     */
    public function restore(User $user, ServiceBooking $serviceBooking)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the service meetings.
     *
     * @param  \App\User  $user
     * @param  \App\Models\ServiceBooking  $serviceBooking
     * @return mixed
     */
    public function forceDelete(User $user, ServiceBooking $serviceBooking)
    {
        //
    }
}
