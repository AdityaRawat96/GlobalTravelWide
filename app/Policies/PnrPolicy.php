<?php

namespace App\Policies;

use App\Models\Pnr;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PnrPolicy
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
        // only allow the user to view the list of pnrs if they have role of admin or digital
        return $user->role === 'admin' || $user->role === 'digital';
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pnr  $pnr
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Pnr $pnr)
    {
        // only allow the pnr to view the list of pnrs if they have role of admin or digital
        return $user->role === 'admin' || $user->role === 'digital';
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        // only allow the user to store a new pnr if they have role of admin or digital
        return $user->role === 'admin' || $user->role === 'digital';
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pnr  $pnr
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Pnr $pnr)
    {
        // only allow the pnr to view the list of pnrs if they have role of admin or digital
        return $user->role === 'admin' || $user->role === 'digital';
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pnr  $pnr
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Pnr $pnr)
    {
        // only allow the pnr to view the list of pnrs if they have role of admin or digital
        return $user->role === 'admin' || $user->role === 'digital';
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pnr  $pnr
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Pnr $pnr)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pnr  $pnr
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Pnr $pnr)
    {
        //
    }
}
