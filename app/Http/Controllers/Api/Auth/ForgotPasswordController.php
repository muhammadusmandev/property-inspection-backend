<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Access\AuthorizationException;
use App\Services\Contracts\ForgotPasswordService as ForgotPasswordServiceContract;
use App\Services\Contracts\OtpService as OtpServiceContract;
use App\Requests\{RequestForgotPasswordRequest, ResetPasswordRequest};
use App\Traits\{ Loggable, ApiJsonResponse };

class ForgotPasswordController extends Controller
{
    use Loggable, ApiJsonResponse;

    protected $forgotPasswordService;
    protected $otpService;

    /**
     * Inject ForgotPasswordServiceContract, OtpServiceContract via constructor.
     * @param \App\Services\Contracts\ForgotPasswordService $forgotPasswordService
     * @param \App\Services\Contracts\OtpServiceContract $otpService
    */
    public function __construct(
        ForgotPasswordServiceContract $forgotPasswordService, 
        OtpServiceContract $otpService
    )
    {
        $this->forgotPasswordService = $forgotPasswordService;
        $this->otpService = $otpService;
    }

    /**
     * Handle forgot password request.
     * @param \App\Http\Requests\RequestForgotPasswordRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     * 
     * @throws \Exception unexpected error
     */
    public function request(RequestForgotPasswordRequest $request): JsonResponse
    {
        try {
            $validData = $request->validated();
            $otp = $this->otpService->generateOTP(
                'email', 
                $validData['email']
            );

            $enableEmailResetLink = false;  // true if want to send email with reset link

            if($enableEmailResetLink){
                $status = Password::sendResetLink(['email' => $validData['email']]);

                if($status !== Password::RESET_LINK_SENT){
                    // status will be 1. Password::INVALID_USER 2. Password::RESET_THROTTLED
                    return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                        'error' => __($status)
                    ], 400);
                }

                $responseMsg = __('validationMessages.reset_link_sent_successfully');
            }

            return $this->successResponse($responseMsg ?? __('validationMessages.otp_sent_successfully'), [
                'otp' => $otp
            ]);

        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.forget_password_api_failed'));

            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage()
            ], 500);
            
        }
    }

    /**
     * Handle reset password.
     * @param \App\Http\Requests\ResetPasswordRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     * 
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception unexpected error
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        try {
            $validData = $request->validated();
            $this->forgotPasswordService->resetPassword(
                $validData['email'],
                $validData['password'],
                $validData['otp_session_token']
            );

            return $this->successResponse(__('validationMessages.passwsord_change_successfully'));

        } catch (AuthorizationException $e) {
            return $this->errorResponse(__('validationMessages.something_went_wrong'),[
                'error' => $e->getMessage()
            ], 403);

        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.otp_resend_api_failed'));

            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage()
            ], 500);
            
        }
    }
}
