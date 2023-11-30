<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use App\Models\SectionYear;
use Illuminate\Auth\Access\Response;

class SectionYearPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }


    public function create(User $user): bool
    {
        return in_array($user->role_id,[Role::IS_ADMIN, Role::IS_STAFF]);

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SectionYear $sectionYear): bool
    {
        return in_array($user->role_id,[Role::IS_ADMIN, Role::IS_STAFF]);

    }


    public function delete(User $user, SectionYear $sectionYear): bool
    {
        return in_array($user->role_id,[Role::IS_ADMIN, Role::IS_STAFF]);

    }

}
