<?php

namespace App\Policies;

use App\Models\Refund;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RefundPolicy
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
        // only allow the user to view the list of refunds if they have role of admin or staff
        return $user->role === 'admin' || $user->role === 'staff';
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Refund  $refund
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Refund $refund)
    {
        // only allow the user to view the list of refunds if they have role of admin or if refund foreign key user_id is the same as the authenticated user
        return $user->role === 'admin' || $user->id === $refund->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        // only allow the user to store a new refund if they have role of admin or staff
        return $user->role === 'admin' || $user->role === 'staff';
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Refund  $refund
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Refund $refund)
    {
        // only allow the user to update an refund if they have role of admin or if refund foreign key user_id is the same as the authenticated user
        return $user->role === 'admin' || $user->id === $refund->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Refund  $refund
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Refund $refund)
    {
        // only allow the user to delete an refund if they have role of admin or if refund foreign key user_id is the same as the authenticated user
        return $user->role === 'admin' || $user->id === $refund->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Refund  $refund
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Refund $refund)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Refund  $refund
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Refund $refund)
    {
        //
    }
}
