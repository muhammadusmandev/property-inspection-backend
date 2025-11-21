<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Requests\{ UpdateProfileRequest, SettingPasswordResetRequest };
use App\Services\Contracts\ProfileService as ProfileServiceContract;
use App\Traits\{ Loggable, ApiJsonResponse };

class ProfileController extends Controller
{
    use Loggable, ApiJsonResponse;

    protected $profileService;

    /**
     * Inject ProfileServiceContract via constructor.
     * @param \App\Services\Contracts\ProfileService $profileService
    */
    public function __construct(ProfileServiceContract $profileService)
    {
        $this->profileService = $profileService;
    }

    /**
     * Get profile data
     *
     * @return \Illuminate\Http\JsonResponse
     * 
     * @throws \Exception unexpected error
     */
    public function getProfile(): JsonResponse
    {
        try {
            $data = $this->profileService->getProfileData();
            return $this->successResponse(__('validationMessages.data_fetch_success'), $data);

        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.resource_fetch_failed', ['resource' => 'Settings Profile']));
            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage()
            ], 500);
            
        }
    }

    /**
     * Update profile data.
     * 
     * @param  \App\Http\Requests\UpdateProfileRequest  $request
     * 
     * @return \Illuminate\Http\JsonResponse
     * 
     * @throws \Exception unexpected error
     */
    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        try {
            $data = $this->profileService->updateProfileData($request->validated());
            return $this->successResponse(__('validationMessages.resource_updated_successfully'), $data);
        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.resource_update_failed', ['resource' => 'Profile Data']));
            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete profile photo.
     * 
     * @return \Illuminate\Http\JsonResponse
     * 
     * @throws \Exception unexpected error
     */
    public function deleteProfilePhoto(): JsonResponse
    {
        try {
            $this->profileService->deleteProfilePhoto();
            return $this->successResponse('Profile Photo deleted successfully.');
        } catch (\Exception $e) {
            $this->logException($e, 'Profile Photo delete Failed.');
            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Reset password.
     * 
     * @param  \App\Http\Requests\SettingPasswordResetRequest  $request
     * 
     * @return \Illuminate\Http\JsonResponse
     * 
     * @throws \Exception unexpected error
     */
    public function resetPassword(SettingPasswordResetRequest $request): JsonResponse
    {
        try {
            $this->profileService->resetPassword($request->validated());
            return $this->successResponse(__('validationMessages.resource_updated_successfully'));
        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.resource_update_failed', ['resource' => 'Password Reset']));
            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
