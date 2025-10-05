<?php

namespace App\Services;

use App\Services\Contracts\AuthService as AuthServiceContract;
use App\Repositories\Contracts\AuthRepository as AuthRepositoryContract;
use App\Services\Contracts\OtpService as OtpServiceContract;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use App\Resources\{ UserLoginResource, UserRegisterResource };
use App\Policies\AuthPolicy;
use Carbon\Carbon;
use App\Models\User;

class AuthService implements AuthServiceContract
{
    protected $authRepository;
    protected $otpService;

    /**
     * Inject AuthRepositoryContract via constructor.
     * @param \App\Repositories\Contracts\AuthRepository $authRepository
    */
    public function __construct(AuthRepositoryContract $authRepository, OtpServiceContract $otpService)
    {
        $this->authRepository = $authRepository;
        $this->otpService = $otpService;
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
            throw new AuthenticationException(__('validationMessages.wrong_credentials'));
        }

        if (!(new AuthPolicy)->userLogin($user)) {
            throw new AuthorizationException(__('validationMessages.email.email_verified'));
        }

        $token = $this->authRepository->createToken($user);

        return new UserLoginResource($user, $token);
    }

    /**
     * Register new user.
     *
     * @param array $userDetails
     * @return \Illuminate\Http\JsonResponse|UserRegisterResource|null
     */

    public function registerUser(array $userDetails): ?UserRegisterResource
    {
        $user = $this->authRepository->createUser($userDetails);
        $otp = $this->otpService->generateOTP($user->id);

        return new UserRegisterResource($user, $otp);
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
