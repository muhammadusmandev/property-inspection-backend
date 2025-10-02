<?php

namespace App\Policies;

use App\Models\User;

class AuthPolicy
{
    /**
     * Check if user allowed to login
     *
     * @param App\Models\User $user
     * @return bool
     */
    public function userLogin(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }
}
