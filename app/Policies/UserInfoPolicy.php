<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Auth\Access\Response;

class UserInfoPolicy
{

    public function view(User $user, UserInfo $userInfo): bool
    {
        return false;
    }


    public function create(User $user): bool
    {
        return in_array($user->role_id,[Role::IS_ADMIN, Role::IS_STAFF]);
    }

    public function update(User $user, UserInfo $userInfo): bool
    {
        return in_array($user->role_id,[Role::IS_ADMIN, Role::IS_STAFF]);
    }

    public function delete(User $user, UserInfo $userInfo): bool
    {
        return in_array($user->role_id,[Role::IS_ADMIN, Role::IS_STAFF]);

    }

}
