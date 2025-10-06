<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Services\Contracts\OtpService as OtpServiceContract;
use App\Traits\{ Loggable, ApiJsonResponse };
use App\Requests\{OTPVerifyRequest, OTPResendRequest};

class OtpVerificationController extends Controller
{
    use Loggable, ApiJsonResponse;

    protected $authService;

    /**
     * Inject OtpServiceContract via constructor.
     * @param \App\Services\Contracts\OtpService $otpService
    */
    public function __construct(OtpServiceContract $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Handle otp verification.
     * @param \App\Http\Requests\OTPVerifyRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     * 
     * @throws \Exception unexpected error
     */
    public function verify(OTPVerifyRequest $request): JsonResponse
    {
        try {
            $validData = $request->validated();
            $verificationData = $this->otpService->verify(
                $validData['identifier'], 
                $validData[$validData['identifier']],
                $validData['otp']
            );

            $message = match($verificationData['status']) {
                'verified' => 'OTP verified successfully.',
                'invalid' => 'OTP is Invalid.',
                'expired' => 'OTP Expired. Try to resend again.',
                default => 'Unknown status',
            };

            return $this->successResponse($message, [
                'status' => $verificationData['status'], 
                'otp_session_token' => $verificationData['otpSessionToken']
            ]);

        } catch (\Exception $e) {
            $this->logException($e, 'OTP Verification API request failed');

            return $this->errorResponse('Oops! Something went wrong.', [
                'error' => $e->getMessage()
            ], 500);
            
        }
    }

    /**
     * Handle resend otp.
     * @param \App\Http\Requests\OTPResendRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     * 
     * @throws \Exception unexpected error
     */
    public function resend(OTPResendRequest $request): JsonResponse
    {
        try {
            $validData = $request->validated();
            $otp = $this->otpService->resend(
                $validData['identifier'], 
                $validData[$validData['identifier']]
            );

            return $this->successResponse('OTP resend successfully.', ['otp' => $otp]);

        } catch (\Exception $e) {
            $this->logException($e, 'OTP resend API request failed');

            return $this->errorResponse('Oops! Something went wrong.', [
                'error' => $e->getMessage()
            ], 500);
            
        }
    }
}
