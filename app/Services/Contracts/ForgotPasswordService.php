<?php

namespace App\Services\Contracts;

use Illuminate\Auth\Access\AuthorizationException;

interface ForgotPasswordService
{
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

    public function resetPassword($email, $password, $otpSessionToken): void;
}