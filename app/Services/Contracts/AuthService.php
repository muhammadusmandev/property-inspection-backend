<?php

namespace App\Services\Contracts;

use App\Resources\{ UserLoginResource, UserRegisterResource };

interface AuthService
{
    /**
     * Attempt to login a user with credentials.
     *
     * @param array $credentials
     * @return \Illuminate\Http\JsonResponse|UserLoginResource|null
     * 
     * @throws \Illuminate\Auth\AuthenticationException on authentication failure
     */
    public function loginUser(array $credentials): ?UserLoginResource;

    /**
     * Register new user.
     *
     * @param array $userDetails
     * @return \Illuminate\Http\JsonResponse|UserRegisterResource|null
     */

    public function registerUser(array $userDetails): ?UserRegisterResource;

    /**
     * Logout current user.
     *
     * @param bool $logoutFromDevices Optional
     * @return void
     */
    public function logoutUser(bool $logoutFromDevices = false): void;
}