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
     * @param string $intent
     * @return array
     */
    public function verify(string $identifier, string $identifierValue, int $otp, string $intent = ""): array;

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