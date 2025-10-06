<?php

namespace App\Services\Contracts;

interface OtpService
{
    /**
     * Verify OTP.
     *
     * @param string $identifier
     * @param string $identifierValue
     * @param int $otp
     * @return string
     */
    public function verify(string $identifier, $identifierValue, int $otp): string;

    /**
     * Resend OTP.
     *
     * @param string $identifier
     * @param string $identifierValue
     * @return int $otp
     */
    public function resend(string $identifier, $identifierValue): int;

    /**
     * Generate OTP and save in caches.
     *
     * @param string $identifier
     * @param string $identifierValue
     * @return int
     */
    public function generateOTP(string $identifier, $identifierValue): int;
}