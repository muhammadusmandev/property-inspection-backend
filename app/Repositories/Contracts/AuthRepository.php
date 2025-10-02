<?php

namespace App\Repositories\Contracts;
use App\Models\User;

interface AuthRepository
{
    /**
     * Attempt to login with credentials.
     *
     * @param array $credentials
     * @return User $user|null
     */
    public function attemptLogin(array $credentials): ?User;

    /**
     * Create Api Token
     *
     * @param User $user
     * @return string
     */
    public function createToken(User $user): string;
}
