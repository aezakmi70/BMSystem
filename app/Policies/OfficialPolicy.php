<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Official;
use Illuminate\Auth\Access\HandlesAuthorization;

class OfficialPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_official');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Official $official): bool
    {
        return $user->can('view_official');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_official');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Official $official): bool
    {
        return $user->can('update_official');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Official $official): bool
    {
        return $user->can('delete_official');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_official');
    }

 


}
