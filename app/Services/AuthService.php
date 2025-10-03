<?php

namespace App\Services;

use App\Services\Contracts\AuthService as AuthServiceContract;
use App\Repositories\Contracts\AuthRepository as AuthRepositoryContract;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use App\Resources\UserLoginResource;
use App\Policies\AuthPolicy;
use App\Models\User;

class AuthService implements AuthServiceContract
{
    protected $authRepository;

    /**
     * Inject AuthRepositoryContract via constructor.
     * @param \App\Repositories\Contracts\AuthRepository $authRepository
    */
    public function __construct(AuthRepositoryContract $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * Attempt to login a user with credentials.
     *
     * @param array $credentials
     * @return \Illuminate\Http\JsonResponse|UserLoginResource|null
     * 
     * @throws \Illuminate\Auth\AuthenticationException on authentication failure
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */

    public function loginUser(array $credentials): ?UserLoginResource
    {
        $user = $this->authRepository->attemptLogin($credentials);

        if (!$user) {
            throw new AuthenticationException('The provided credentials are incorrect.');
        }

        if (!(new AuthPolicy)->userLogin($user)) {
            throw new AuthorizationException('Your email must need to be verified.');
        }

        $token = $this->authRepository->createToken($user);

        return new UserLoginResource($user, $token);
    }

    /**
     * Attempt to logout current user.
     *
     * @param bool $logoutFromDevices Optional
     * @return void
     */

    public function logoutUser(bool $logoutFromDevices = false): void
    {
        $token = request()->user()?->currentAccessToken();

        // revoke if token is valid otherwise (missing, invalid, already logged out or deleted)
        if($token){
            $this->authRepository->revokeToken($logoutFromDevices);
        }
    }
}
