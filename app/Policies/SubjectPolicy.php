<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Auth\Access\Response;

class SubjectPolicy
{

    public function viewAny(User $user): bool
    {
       return true;
    }

    public function create(User $user): bool
    {
        return in_array($user->role_id,[Role::IS_ADMIN, Role::IS_STAFF]);

    }


    public function update(User $user, Subject $subject): bool
    {
        return in_array($user->role_id,[Role::IS_ADMIN, Role::IS_STAFF]);

    }

    public function delete(User $user, Subject $subject): bool
    {
        return in_array($user->role_id,[Role::IS_ADMIN, Role::IS_STAFF]);

    }


}
