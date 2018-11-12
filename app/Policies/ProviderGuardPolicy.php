<?php

namespace App\Policies;

use App\User;
use App\Models\Provider;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class ProviderGuardPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the provider.
     *
     * @param Provider $provider
     * @return bool
     */
    public function view(Provider $provider)
    {
//        dd(Auth::user());
        return Auth::guard('provider-web')->user()->id === $provider->id;
    }

    /**
     * Determine whether the user can create providers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(Provider $provider)
    {
        return Auth::guard('provider-web')->user()->id === $provider->id;
    }

    /**
     * Determine whether the user can update the provider.
     *
     * @param Provider $provider
     * @return bool
     */
    public function update(Provider $provider)
    {
        return Auth::guard('provider-web')->user()->id === $provider->id;
    }

    /**
     * Determine whether the user can delete the provider.
     *
     * @param Provider $provider
     * @return bool
     */
    public function delete(Provider $provider)
    {
        return Auth::guard('provider-web')->user()->id === $provider->id;
    }

    /**
     * Determine whether the user can restore the provider.
     *
     * @param Provider $provider
     * @return bool
     */
    public function restore(Provider $provider)
    {
        return Auth::guard('provider-web')->user()->id === $provider->id;
    }

    /**
     * Determine whether the user can permanently delete the provider.
     *
     * @param Provider $provider
     * @return bool
     */
    public function forceDelete(Provider $provider)
    {
        return Auth::guard('provider-web')->user()->id === $provider->id;
    }
}
