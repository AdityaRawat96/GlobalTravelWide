<?php

namespace App\Policies;

use App\Models\Quotation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuotationPolicy
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
        // only allow the user to view the list of quotations if they have role of admin or staff
        return $user->role === 'admin' || $user->role === 'staff';
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Quotation $quotation)
    {
        // only allow the user to view the list of quotations if they have role of admin or if quotation foreign key user_id is the same as the authenticated user
        return $user->role === 'admin' || $user->id === $quotation->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        // only allow the user to store a new quotation if they have role of admin or staff
        return $user->role === 'admin' || $user->role === 'staff';
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Quotation $quotation)
    {
        // only allow the user to update an quotation if they have role of admin or if quotation foreign key user_id is the same as the authenticated user
        return $user->role === 'admin' || $user->id === $quotation->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Quotation $quotation)
    {
        // only allow the user to delete an quotation if they have role of admin or if quotation foreign key user_id is the same as the authenticated user
        return $user->role === 'admin' || $user->id === $quotation->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Quotation $quotation)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Quotation $quotation)
    {
        //
    }
}
