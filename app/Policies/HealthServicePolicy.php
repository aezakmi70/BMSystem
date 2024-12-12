<?php

namespace App\Policies;

use App\Models\User;
use App\Models\HealthService;
use Illuminate\Auth\Access\HandlesAuthorization;

class HealthServicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any health services.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_health::service');
    }

    /**
     * Determine whether the user can view a specific health service.
     */
    public function view(User $user, HealthService $healthService): bool
    {
        return $user->can('view_health::service');
    }

    /**
     * Determine whether the user can create a health service.
     */
    public function create(User $user): bool
    {
        return $user->can('create_health::service');
    }

    /**
     * Determine whether the user can update the health service.
     */
    public function update(User $user, HealthService $healthService): bool
    {
        return $user->can('update_health::service');
    }

    /**
     * Determine whether the user can delete a health service.
     */
    public function delete(User $user, HealthService $healthService): bool
    {
        return $user->can('delete_health::service');
    }

    /**
     * Determine whether the user can bulk delete health services.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_health::service');
    }

    /**
     * Determine whether the user can reorder health services.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_health::service');
    }
}
