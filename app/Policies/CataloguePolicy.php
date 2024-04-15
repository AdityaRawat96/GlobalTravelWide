<?php

namespace App\Policies;

use App\Models\Catalogue;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CataloguePolicy
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
        // only allow the user to view the catalogues if they have role of admin or staff
        return $user->role === 'admin' || $user->role === 'staff';
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Catalogue  $catalogue
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Catalogue $catalogue)
    {
        // only allow the user to view the catalogue if they have role of admin or staff
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
        // only allow the user to create a catalogue if they have role of admin or staff
        return $user->role === 'admin' || $user->role === 'staff';
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Catalogue  $catalogue
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Catalogue $catalogue)
    {
        // only allow the user to update the catalogue if they have role of admin or staff
        return $user->role === 'admin' || $user->role === 'staff';
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Catalogue  $catalogue
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Catalogue $catalogue)
    {
        // only allow the user to delete the catalogue if they have role of admin or staff
        return $user->role === 'admin' || $user->role === 'staff';
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Catalogue  $catalogue
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Catalogue $catalogue)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Catalogue  $catalogue
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Catalogue $catalogue)
    {
        //
    }
}
