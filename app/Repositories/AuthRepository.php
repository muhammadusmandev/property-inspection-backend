<?php

namespace App\Repositories;

use App\Repositories\Contracts\AuthRepository as AuthRepositoryContract;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthRepository implements AuthRepositoryContract
{
    /**
     * Attempt to login with credentials.
     *
     * @param array $credentials
     * @return User $user|null
     */
    public function attemptLogin(array $credentials): ?User
    {
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return null;
        }

        return $user;
    }

    /**
     * Create Api Token
     *
     * @param User $user
     * @return string
     */
    public function createToken($user): string
    {
        return $user->createToken('api_token')->plainTextToken;
    }

    /**
     * Revoke current user token/tokens
     *
     * @param bool $logoutFromDevices Optional
     * @return void
     */
    public function revokeToken(bool $logoutFromDevices = false): void
    {
        $logoutFromDevices ?
            // revoke all token to logout from all devices
            request()->user()->tokens()->delete()
        :
            // revoke only current token
            request()->user()->currentAccessToken()->delete()
        ;
    }
}