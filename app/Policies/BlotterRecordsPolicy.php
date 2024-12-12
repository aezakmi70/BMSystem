<?php

namespace App\Policies;

use App\Models\User;
use App\Models\BlotterRecords;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlotterRecordsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_blotter::records');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BlotterRecords $blotterRecords): bool
    {
        return $user->can('view_blotter::records');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_blotter::records');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BlotterRecords $blotterRecords): bool
    {
        return $user->can('update_blotter::records');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BlotterRecords $blotterRecords): bool
    {
        return $user->can('delete_blotter::records');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_blotter::records');
    }


    public function reorder(User $user): bool
    {
        return $user->can('reorder_blotter::records');
    }
}
