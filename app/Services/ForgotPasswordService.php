<?php

namespace App\Services;

use App\Services\Contracts\ForgotPasswordService as ForgotPasswordServiceContract;
use App\Repositories\Contracts\ForgotPasswordRepository as ForgotPasswordRepositoryContract;

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
     * @return void
     */

    public function resetPassword($email, $password): void
    {
        $this->forgotPasswordRepository->attemptResetPassword($email, $password);
    }
}