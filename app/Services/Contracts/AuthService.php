<?php

namespace App\Services\Contracts;

use App\Resources\UserLoginResource;

interface AuthService
{
    /**
     * Login user with credentials.
     *
     * @param array $credentials
     * @return \Illuminate\Http\JsonResponse|UserLoginResource|null
     */
    public function loginUser(array $credentials): ?UserLoginResource;

    /**
     * Logout current user.
     *
     * @param bool $logoutFromDevices Optional
     * @return void
     */
    public function logoutUser(bool $logoutFromDevices = false): void;
}