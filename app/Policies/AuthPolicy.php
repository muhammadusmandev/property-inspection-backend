<?php

namespace App\Policies;

use App\Models\User;

class AuthPolicy
{
    /**
     * Allowed roles for login.
     * @param App\Models\User $user
     * @return bool
     */
    public function allowedRoles(User $user): bool
    {
        return !empty(array_intersect($user->getRoleNames()->toArray(), ['inspector']));
    }
}
