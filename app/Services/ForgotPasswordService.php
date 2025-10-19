<?php

namespace App\Services;

use App\Services\Contracts\ForgotPasswordService as ForgotPasswordServiceContract;
use App\Repositories\Contracts\ForgotPasswordRepository as ForgotPasswordRepositoryContract;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Cache;

class ForgotPasswordService implements ForgotPasswordServiceContract
{
    protected $forgotPasswordRepository;

    /**
     * Inject ForgotPasswordRepository via constructor.
     * @param \App\Repositories\Contracts\ForgotPasswordRepositoryContract $forgotPasswordRepository
    */
    public function __construct(ForgotPasswordRepositoryContract $forgotPasswordRepository)
    {
        $this->forgotPasswordRepository = $forgotPasswordRepository;
    }

    /**
     * Handle reset password
     *
     * @param string $email
     * @param string $password
     * @param string $otpSessionToken
     * @return void
     * 
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */

    public function resetPassword($email, $password, $otpSessionToken): void
    {
        $otpVerifiedKey = "otp-verified:$email";

        if (!Cache::has($otpVerifiedKey) || (Cache::get($otpVerifiedKey) !== $otpSessionToken)) {
            throw new AuthorizationException(__('validationMessages.otp.token_expired_invalid'));
        }

        // reset the password if otp session token match
        $this->forgotPasswordRepository->attemptResetPassword($email, $password);
        Cache::forget($otpVerifiedKey);
    }
}