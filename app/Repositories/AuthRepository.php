<?php

namespace App\Repositories;

use App\Repositories\Contracts\AuthRepository as AuthRepositoryContract;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Exception;
use App\Models\User;
use Carbon\Carbon;

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
     * @return array
     */
    public function createToken($user): array
    {
        // Todo: Handle proper DB query
        $token = $user->createToken('api_token');
        $token->accessToken->expires_at = Carbon::now()->addMinutes(config('sanctum.expiration'));
        $token->accessToken->save();
        
        return ['token' => $token->plainTextToken, 'expires_at' => $token->accessToken->expires_at?->toIso8601String()];
    }

    /**
     * Create new user
     *
     * @param array $userDetails
     * @return User $user
     * 
     * @throws \Illuminate\Database\QueryException database query fails exception.
     * @throws Exception general exception.
     */
    public function createUser(array $userDetails): User
    {
        try {
            return DB::transaction(function () use ($userDetails) {
                $user =  User::create([
                    'name' => $userDetails['first_name'] . ' ' . $userDetails['last_name'],
                    'email' => $userDetails['email'],
                    'password' => Hash::make($userDetails['password']),
                    'phone_number' => $userDetails['phone_number'] ? phone($userDetails['phone_number'])->formatE164() : null,
                    'profile_photo' => $userDetails['profile_photo'] ?? null,
                    'gender' => $userDetails['gender'],
                    'date_of_birth' => $userDetails['date_of_birth'],
                ]);

                $user->assignRole('realtor');

                return $user;
            });
        } catch (QueryException $qe) {
            throw $qe;
        } catch (Exception $e) {
            throw $e;
        }
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