<?php

namespace App\Policies;

use App\Models\Questionaire;
use App\Models\Role;
use App\Models\User;

class QuestionairePolicy
{
    public function viewAny(User $user): bool
    {

        return true;
    }

    public function view(User $user, Questionaire $questionaire): bool
    {
        return true;
    }


    public function create(User $user): bool
    {
        return in_array($user->role_id,[Role::IS_ADMIN, Role::IS_STAFF]);

    }


    public function update(User $user, Questionaire $questionaire): bool
    {
        return in_array($user->role_id,[Role::IS_ADMIN, Role::IS_STAFF]);
    }

    public function delete(User $user, Questionaire $questionaire): bool
    {
        return in_array($user->role_id,[Role::IS_ADMIN, Role::IS_STAFF]);

    }

}
