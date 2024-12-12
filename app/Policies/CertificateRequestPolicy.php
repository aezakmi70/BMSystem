<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CertificateRequest;
use Illuminate\Auth\Access\HandlesAuthorization;

class CertificateRequestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_certificate::request');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CertificateRequest $certificateRequest): bool
    {
        return $user->can('view_certificate::request');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_certificate::request');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CertificateRequest $certificateRequest): bool
    {
        return $user->can('update_certificate::request');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CertificateRequest $certificateRequest): bool
    {
        return $user->can('delete_certificate::request');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_certificate::request');
    }

  
    public function reorder(User $user): bool
    {
        return $user->can('reorder_certificate::request');
    }
}
