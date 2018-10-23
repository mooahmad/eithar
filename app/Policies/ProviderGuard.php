<?php

namespace App\Policies;

use App\User;
use App\Models\Provider;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProviderGuard
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the provider.
     *
     * @return mixed
     */
    public function view()
    {
        return true;
        dd($provider);
    }

    /**
     * Determine whether the user can create providers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the provider.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Provider  $provider
     * @return mixed
     */
    public function update(User $user, Provider $provider)
    {
        //
    }

    /**
     * Determine whether the user can delete the provider.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Provider  $provider
     * @return mixed
     */
    public function delete(User $user, Provider $provider)
    {
        //
    }

    /**
     * Determine whether the user can restore the provider.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Provider  $provider
     * @return mixed
     */
    public function restore(User $user, Provider $provider)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the provider.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Provider  $provider
     * @return mixed
     */
    public function forceDelete(User $user, Provider $provider)
    {
        //
    }
}
