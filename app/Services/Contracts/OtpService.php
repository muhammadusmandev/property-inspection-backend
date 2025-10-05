<?php

namespace App\Services\Contracts;

interface OtpService
{
    /**
     * Verify OTP.
     *
     * @param int $user_id
     * @param int $otp
     * @return string
     */
    public function verify(int $user_id, int $otp): string;

    /**
     * Resend OTP.
     *
     * @param int $userId
     * @return int $otp
     */
    public function resend(int $userId): int;

    /**
     * Generate OTP and save in caches.
     *
     * @param int $userId
     * @return int
     */
    public function generateOTP($userId): int;
}