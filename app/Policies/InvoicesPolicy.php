<?php

namespace App\Policies;

use App\User;
use App\Models\Invoices;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvoicesPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the invoices.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Invoices  $invoices
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->user_type === config('constants.userTypes.superAdmin');
    }

    /**
     * Determine whether the user can create invoices.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->user_type === config('constants.userTypes.superAdmin');
    }

    /**
     * Determine whether the user can update the invoices.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Invoices  $invoices
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->user_type === config('constants.userTypes.superAdmin');
    }

    /**
     * Determine whether the user can delete the invoices.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Invoices  $invoices
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->user_type === config('constants.userTypes.superAdmin');
    }

    /**
     * Determine whether the user can restore the invoices.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Invoices  $invoices
     * @return mixed
     */
    public function restore(User $user)
    {
        return $user->user_type === config('constants.userTypes.superAdmin');
    }

    /**
     * Determine whether the user can permanently delete the invoices.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Invoices  $invoices
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        return $user->user_type === config('constants.userTypes.superAdmin');
    }
}
