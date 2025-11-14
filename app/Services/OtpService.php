<?php

namespace App\Services;

use App\Services\Contracts\OtpService as OtpServiceContract;
use Illuminate\Support\Facades\Cache;
use App\Enums\OtpIdentifier;
use App\Events\RegistrationOtpVerified;
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
     * @param string $identifier
     * @param string $identifierValue
     * @param int $otp
     * @param string $intent
     * @return array
     */
    public function verify(string $identifier, string $identifierValue, int $otp, string $intent = ""): array
    {
        OtpIdentifier::in($identifier);
        
        // format phone before checking
        if($identifier === "phone")
            $identifierValue = phone($identifierValue)->formatE164();

        $otpKey = "otp:$identifierValue";

        // check if user cache not expired or invalid or otp value match
        if (Cache::has($otpKey)) {
            if (Cache::get($otpKey) === $otp) {
                Cache::forget($otpKey);
                $status = 'verified';
                
                if($intent === "registration"){
                    // Todo: additional logic if email/phone verified
                    $user = User::where($identifier, $identifierValue)->first();
                    $user->email_verified_at = now();
                    $user->update();

                    event(new RegistrationOtpVerified($user));
                }
                
                // Cache temporary otp verification token (Useful in next api calls e.g. reset password api)
                $otpSessionToken = \Str::uuid()->toString();
                Cache::put("otp-verified:{$identifierValue}", $otpSessionToken, now()->addMinutes(self::OTP_CACHE_TTL));
            } else{
                $status = 'invalid';
            }
        } else{
            $status = 'expired';
        }

        return ['status' => $status, 'otpSessionToken' => $otpSessionToken ?? null];
    }

    /**
     * Resend OTP.
     *
     * @param string $identifier
     * @param string $identifierValue
     * @return int $otp
     */
    public function resend(string $identifier, $identifierValue): int
    {
        return $this->generateOTP($identifier, $identifierValue);
    }

    /**
     * Generate OTP and save in caches.
     *
     * @param string $identifier
     * @param string $identifierValue
     * @return int
     */
    public function generateOTP(string $identifier, $identifierValue): int
    {
        OtpIdentifier::in($identifier);

        // format phone before cache
        if($identifier === "phone")
            $identifierValue = phone($identifierValue)->formatE164();

        // Generate random 6 digits otp
        $otp = rand(100000, 999999);
        $otpKey = "otp:$identifierValue";

        // Save otp in cache with ttl/expiry
        Cache::put($otpKey, $otp, now()->addMinutes(self::OTP_CACHE_TTL));

        // Otp resend limiter
        $resendCooldown = self::RESEND_COOL_DOWN;
        $resendLimiterKey = "otp-resend:$identifierValue";
        
        Cache::put($resendLimiterKey, true, $resendCooldown);

        return $otp;
    }
}