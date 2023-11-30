<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use App\Models\Criteria;
use Illuminate\Auth\Access\Response;

class CriteriaPolicy
{

    public function viewAny(User $user): bool
    {
        return true;
    }


    public function view(User $user, Criteria $criteria): bool
    {
        return true;
    }


    public function create(User $user): bool
    {
        return in_array($user->role_id,[Role::IS_ADMIN, Role::IS_STAFF]);
    }


    public function update(User $user, Criteria $criteria): bool
    {
        return in_array($user->role_id,[Role::IS_ADMIN, Role::IS_STAFF]);
    }


    public function delete(User $user, Criteria $criteria): bool
    {
        return in_array($user->role_id,[Role::IS_ADMIN, Role::IS_STAFF]);
    }


}
