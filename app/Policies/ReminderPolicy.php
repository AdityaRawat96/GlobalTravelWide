<?php

namespace App\Policies;

use App\Models\Reminder;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReminderPolicy
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
        // only allow the user to view the list of reminders if they have role of admin or staff
        return $user->role === 'admin' || $user->role === 'staff';
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Reminder  $reminder
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Reminder $reminder)
    {
        // only allow the reminder to view the list of reminders if they have role of admin or staff
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
        // only allow the user to store a new reminder if they have role of admin or staff
        return $user->role === 'admin' || $user->role === 'staff';
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Reminder  $reminder
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Reminder $reminder)
    {
        // only allow the reminder to view the list of reminders if they have role of admin or staff
        return $user->role === 'admin' || $user->role === 'staff';
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Reminder  $reminder
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Reminder $reminder)
    {
        // only allow the reminder to view the list of reminders if they have role of admin or staff
        return $user->role === 'admin' || $user->role === 'staff';
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Reminder  $reminder
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Reminder $reminder)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Reminder  $reminder
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Reminder $reminder)
    {
        //
    }
}
