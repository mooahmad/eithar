<?php

namespace App\Policies;

use App\User;
use App\Models\Customer;
use Illuminate\Auth\Access\HandlesAuthorization;

class FamilyMemberPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the customer.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Customer  $customer
     * @return mixed
     */
    public function view(User $user)
    {
	    if ($user->user_type == config('constants.userTypes.customerService')) return true;
	    return false;
    }

    /**
     * Determine whether the user can create customers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
	    if ($user->user_type == config('constants.userTypes.customerService')) return true;
	    return false;
    }

    /**
     * Determine whether the user can update the customer.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Customer  $customer
     * @return mixed
     */
    public function update(User $user)
    {
	    if ($user->user_type == config('constants.userTypes.customerService')) return true;
	    return false;
    }

    /**
     * Determine whether the user can delete the customer.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Customer  $customer
     * @return mixed
     */
    public function delete(User $user)
    {
	    if ($user->user_type == config('constants.userTypes.customerService')) return true;
	    return false;
    }

    /**
     * Determine whether the user can restore the customer.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Customer  $customer
     * @return mixed
     */
    public function restore(User $user)
    {
	    if ($user->user_type == config('constants.userTypes.customerService')) return true;
	    return false;
    }

    /**
     * Determine whether the user can permanently delete the customer.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Customer  $customer
     * @return mixed
     */
    public function forceDelete(User $user)
    {
	    if ($user->user_type == config('constants.userTypes.customerService')) return true;
	    return false;
    }
}
