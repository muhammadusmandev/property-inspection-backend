<?php

namespace App\Services;

use App\Services\Contracts\OtpService as OtpServiceContract;
use Illuminate\Support\Facades\Cache;
use App\Models\User;

class OtpService implements OtpServiceContract
{
    /**
     * OTP resend try after time (seconds)
     * 
     * @var int
     */
    protected const RESEND_COOL_DOWN = 60;

    /**
     * OTP cache TTL in minutes
     * @var int
     */
    protected const OTP_CACHE_TTL = 30;

    /**
     * Verify OTP.
     *
     * @param int $user_id
     * @param int $otp
     * @return string
     */
    public function verify(int $user_id, int $otp): string
    {
        $user = User::findOrFail($user_id);
        $otpKey = "otp:$user->id";

        // check if user cache not expired or invalid or otp value match
        if (Cache::has($otpKey)) {
            if (Cache::get($otpKey) === $otp) {
                Cache::forget($otpKey);
                // Todo: additional logic if email/phone verified
                $status = 'verified';
            } else{
                $status = 'invalid';
            }
        } else{
            $status = 'expired';
        }

        return $status;
    }

    /**
     * Resend OTP.
     *
     * @param int $userId
     * @return int $otp
     */
    public function resend(int $userId): int
    {
        return $this->generateOTP($userId);
    }

    /**
     * Generate OTP and save in caches.
     *
     * @param int $userId
     * @return int
     */
    public function generateOTP($userId): int
    {
        // Generate random 6 digits otp
        $otp = rand(100000, 999999);
        $otpKey = "otp:$userId";

        // Save otp in cache with ttl/expiry
        Cache::put($otpKey, $otp, now()->addMinutes(self::OTP_CACHE_TTL));

        // Otp resend limiter
        $resendCooldown = self::RESEND_COOL_DOWN;
        $resendLimiterKey = "otp-resend:$userId";
        
        Cache::put($resendLimiterKey, true, $resendCooldown);

        return $otp;
    }
}