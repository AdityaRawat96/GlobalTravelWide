<?php

namespace App\Policies;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExpensePolicy
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
        // only allow the user to view the list of expenses if they have role of admin 
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Expense $expense)
    {
        // only allow the expense to view the list of expenses if they have role of admin 
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        // only allow the user to store a new expense if they have role of admin 
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Expense $expense)
    {
        // only allow the expense to view the list of expenses if they have role of admin 
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Expense $expense)
    {
        // only allow the expense to view the list of expenses if they have role of admin
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Expense $expense)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Expense $expense)
    {
        //
    }
}
