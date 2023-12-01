<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return in_array($user->role_id,[Role::IS_ADMIN, Role::IS_STAFF]);
        // return true;
    }

    public function update(User $user, User $model): bool
    {
        return in_array($user->role_id,[Role::IS_ADMIN, Role::IS_STAFF]);

    }

    public function delete(User $user, User $model): bool
    {
        return in_array($user->role_id,[Role::IS_ADMIN, Role::IS_STAFF]);

    }
}
