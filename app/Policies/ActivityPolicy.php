<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ActivityPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_activity');
    }

    public function view(User $user): bool
    {
        return $user->can('view_activity');
    }

    public function create(User $user): bool
    {
        return $user->can('create_activity');
    }

    public function update(User $user): bool
    {
        return $user->can('update_activity');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_activity');
    }

    public function delete(User $user): bool
    {
        return $user->can('delete_activity');
    }

    public function forceDelete(User $user): bool
    {
        return $user->can('force_delete_activity');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_activity');
    }


    public function restore(User $user): bool
    {
        return $user->can('restore_activity');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_activity');
    }

    public function replicate(User $user): bool
    {
        return $user->can('replicate_activity');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_activity');
    }
}
