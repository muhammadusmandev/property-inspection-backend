<?php

namespace App\Repositories\Contracts;

interface ForgotPasswordRepository
{
    /**
     * Attempt to reset password (new password).
     *
     * @param string $email
     * @param string $password
     * @return void
     * 
     * @throws \Illuminate\Database\QueryException database query fails exception.
     * @throws Exception general exception.
     */
    public function attemptResetPassword(string $email, string $password): void;
}
