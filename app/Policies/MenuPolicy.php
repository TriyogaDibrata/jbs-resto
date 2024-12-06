<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_menu');
    }

    public function view(User $user): bool
    {
        return $user->can('view_menu');
    }

    public function create(User $user): bool
    {
        return $user->can('create_menu');
    }

    public function update(User $user): bool
    {
        return $user->can('update_menu');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_menu');
    }

    public function delete(User $user): bool
    {
        return $user->can('delete_menu');
    }

    public function forceDelete(User $user): bool
    {
        return $user->can('force_delete_menu');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_menu');
    }


    public function restore(User $user): bool
    {
        return $user->can('restore_menu');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_menu');
    }

    public function replicate(User $user): bool
    {
        return $user->can('replicate_menu');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_menu');
    }
}
