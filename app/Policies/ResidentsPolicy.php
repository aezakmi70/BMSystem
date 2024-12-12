<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Residents;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResidentsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_residents');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Residents $residents): bool
    {
        return $user->can('view_residents');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_residents');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Residents $residents): bool
    {
        return $user->can('update_residents');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Residents $residents): bool
    {
        return $user->can('delete_residents');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_residents');
    }

   

}
