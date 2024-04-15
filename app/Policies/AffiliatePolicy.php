<?php

namespace App\Policies;

use App\Models\Affiliate;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AffiliatePolicy
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
        // only allow the user to view the list of affiliates if they have role of admin
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Affiliate  $affiliate
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Affiliate $affiliate)
    {
        // only allow the affiliate to view the list of affiliates if they have role of admin or if affiliate foreign key added_by is the same as the authenticated user
        return $user->role === 'admin' || $user->id === $affiliate->added_by;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        // only allow the user to store a new affiliate if they have role of admin or staff
        return $user->role === 'admin' || $user->role === 'staff';
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Affiliate  $affiliate
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Affiliate $affiliate)
    {
        // only allow the affiliate to view the list of affiliates if they have role of admin or if affiliate foreign key added_by is the same as the authenticated user
        return $user->role === 'admin' || $user->id === $affiliate->added_by;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Affiliate  $affiliate
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Affiliate $affiliate)
    {
        // only allow the affiliate to view the list of affiliates if they have role of admin or if affiliate foreign key added_by is the same as the authenticated user
        return $user->role === 'admin' || $user->id === $affiliate->added_by;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Affiliate  $affiliate
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Affiliate $affiliate)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Affiliate  $affiliate
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Affiliate $affiliate)
    {
        //
    }
}
