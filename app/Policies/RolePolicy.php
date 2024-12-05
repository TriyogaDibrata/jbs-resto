<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_role');
    }

    public function view(User $user): bool
    {
        return $user->can('view_role');
    }

    public function create(User $user): bool
    {
        return $user->can('create_role');
    }

    public function update(User $user): bool
    {
        return $user->can('update_role');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_role');
    }

    public function delete(User $user): bool
    {
        return $user->can('delete_role');
    }
}
