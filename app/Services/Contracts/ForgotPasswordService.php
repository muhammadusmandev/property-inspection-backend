<?php

namespace App\Services\Contracts;

interface ForgotPasswordService
{
    /**
     * Handle reset password
     *
     * @param string $email
     * @param string $password
     * @return void
     */

    public function resetPassword($email, $password): void;
}