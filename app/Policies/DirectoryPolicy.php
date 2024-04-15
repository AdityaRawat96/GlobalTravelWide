<?php

namespace App\Policies;

use App\Models\Directory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class DirectoryPolicy
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
        // Only admin and staff roles can view all directories
        return Auth::user()->role === 'admin' || Auth::user()->role === 'staff';
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Directory  $directory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user)
    {
        // Only admin and staff roles can view all directories
        return in_array($user->role, ['admin', 'staff']);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        // Only admin can create a directory
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Directory  $directory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user)
    {
        // Only admin can update a directory
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Directory  $directory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user)
    {
        // Only admin can update a directory
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Directory  $directory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Directory $directory)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Directory  $directory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Directory $directory)
    {
        //
    }
}