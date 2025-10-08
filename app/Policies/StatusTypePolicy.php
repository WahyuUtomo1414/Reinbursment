<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\StatusType;
use Illuminate\Auth\Access\HandlesAuthorization;

class StatusTypePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:StatusType');
    }

    public function view(AuthUser $authUser, StatusType $statusType): bool
    {
        return $authUser->can('View:StatusType');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:StatusType');
    }

    public function update(AuthUser $authUser, StatusType $statusType): bool
    {
        return $authUser->can('Update:StatusType');
    }

    public function delete(AuthUser $authUser, StatusType $statusType): bool
    {
        return $authUser->can('Delete:StatusType');
    }

    public function restore(AuthUser $authUser, StatusType $statusType): bool
    {
        return $authUser->can('Restore:StatusType');
    }

    public function forceDelete(AuthUser $authUser, StatusType $statusType): bool
    {
        return $authUser->can('ForceDelete:StatusType');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:StatusType');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:StatusType');
    }

    public function replicate(AuthUser $authUser, StatusType $statusType): bool
    {
        return $authUser->can('Replicate:StatusType');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:StatusType');
    }

}