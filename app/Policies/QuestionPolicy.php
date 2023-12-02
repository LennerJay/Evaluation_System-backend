<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;

class QuestionPolicy
{


    public function create(User $user): bool
    {
        return in_array($user->role_id,[Role::IS_ADMIN, Role::IS_STAFF]);

    }
    public function update(User $user): bool
    {
        return in_array($user->role_id,[Role::IS_ADMIN, Role::IS_STAFF]);
    }

    public function delete(User $user): bool
    {
        return in_array($user->role_id,[Role::IS_ADMIN, Role::IS_STAFF]);

    }

}
