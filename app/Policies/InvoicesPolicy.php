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
    public function view(User $user, Invoices $invoices)
    {
        //
    }

    /**
     * Determine whether the user can create invoices.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the invoices.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Invoices  $invoices
     * @return mixed
     */
    public function update(User $user, Invoices $invoices)
    {
        //
    }

    /**
     * Determine whether the user can delete the invoices.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Invoices  $invoices
     * @return mixed
     */
    public function delete(User $user, Invoices $invoices)
    {
        //
    }

    /**
     * Determine whether the user can restore the invoices.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Invoices  $invoices
     * @return mixed
     */
    public function restore(User $user, Invoices $invoices)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the invoices.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Invoices  $invoices
     * @return mixed
     */
    public function forceDelete(User $user, Invoices $invoices)
    {
        //
    }
}
