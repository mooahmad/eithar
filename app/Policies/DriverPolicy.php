<?php

namespace App\Policies;

use App\User;
use App\Models\Driver;
use Illuminate\Auth\Access\HandlesAuthorization;

class DriverPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function view(User $user, Driver $model)
    {
	    if ($user->user_type === config('constants.userTypes.superAdmin')) return true;
	    return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
	    if ($user->user_type === config('constants.userTypes.superAdmin')) return true;
	    return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function update(User $user, Driver $model)
    {
	    if ($user->user_type === config('constants.userTypes.superAdmin')) return true;
	    return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function delete(User $user, Driver $model)
    {
	    if ($user->user_type === config('constants.userTypes.superAdmin')) return true;
	    return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function restore(User $user, Driver $model)
    {
	    if ($user->user_type === config('constants.userTypes.superAdmin')) return true;
	    return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function forceDelete(User $user, Driver $model)
    {
	    if ($user->user_type === config('constants.userTypes.superAdmin')) return true;
	    return false;
    }
}
