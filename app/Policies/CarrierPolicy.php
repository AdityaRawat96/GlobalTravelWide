<?php

namespace App\Policies;

use App\Models\Carrier;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CarrierPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        // only allow the user to view the carriers if they have role of admin or staff
        return $user->role === 'admin' || $user->role === 'staff';
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Carrier  $carrier
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Carrier $carrier)
    {
        // only allow the user to view the carrier if they have role of admin or staff
        return $user->role === 'admin' || $user->role === 'staff';
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        // only allow the user to create a carrier if they have role of admin or staff
        return $user->role === 'admin' || $user->role === 'staff';
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Carrier  $carrier
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Carrier $carrier)
    {
        // only allow the user to update the carrier if they have role of admin or staff
        return $user->role === 'admin' || $user->role === 'staff';
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Carrier  $carrier
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Carrier $carrier)
    {
        // only allow the user to delete the carrier if they have role of admin or staff
        return $user->role === 'admin' || $user->role === 'staff';
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Carrier  $carrier
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Carrier $carrier)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Carrier  $carrier
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Carrier $carrier)
    {
        //
    }
}
