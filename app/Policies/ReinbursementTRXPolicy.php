<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ReinbursementTRX;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReinbursementTRXPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ReinbursementTRX');
    }

    public function view(AuthUser $authUser, ReinbursementTRX $reinbursementTRX): bool
    {
        return $authUser->can('View:ReinbursementTRX');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ReinbursementTRX');
    }

    public function update(AuthUser $authUser, ReinbursementTRX $reinbursementTRX): bool
    {
        return $authUser->can('Update:ReinbursementTRX');
    }

    public function delete(AuthUser $authUser, ReinbursementTRX $reinbursementTRX): bool
    {
        return $authUser->can('Delete:ReinbursementTRX');
    }

    public function restore(AuthUser $authUser, ReinbursementTRX $reinbursementTRX): bool
    {
        return $authUser->can('Restore:ReinbursementTRX');
    }

    public function forceDelete(AuthUser $authUser, ReinbursementTRX $reinbursementTRX): bool
    {
        return $authUser->can('ForceDelete:ReinbursementTRX');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ReinbursementTRX');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ReinbursementTRX');
    }

    public function replicate(AuthUser $authUser, ReinbursementTRX $reinbursementTRX): bool
    {
        return $authUser->can('Replicate:ReinbursementTRX');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ReinbursementTRX');
    }

}