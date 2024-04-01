<?php

namespace App\Policies;

use App\Models\Sale;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SalePolicy
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
        // only allow the user to view the list of sales if they have role of admin
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, User $user_active)
    {
        // only allow the user to view the list of sales if they have role of admin or if sale foreign key user_id is the same as the authenticated user
        return $user->role === 'admin' || $user->id === $user_active->id;
    }
}