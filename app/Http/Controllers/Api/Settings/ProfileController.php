<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Requests\UpdateProfileRequest;
use App\Services\Contracts\SettingsService as SettingsServiceContract;
use App\Traits\{ Loggable, ApiJsonResponse };

class ProfileController extends Controller
{
    use Loggable, ApiJsonResponse;

    protected $settingsService;

    /**
     * Inject SettingsServiceContract via constructor.
     * @param \App\Services\Contracts\SettingsService $settingsService
    */
    public function __construct(SettingsServiceContract $settingsService)
    {
        $this->settingsService = $settingsService;
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
            $data = $this->settingsService->getProfileData();
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
            $data = $this->settingsService->updateProfileData($request->validated());
            return $this->successResponse(__('validationMessages.resource_updated_successfully'), $data);
        } catch (\Exception $e) {
            $this->logException($e, __('validationMessages.resource_update_failed', ['resource' => 'Profile Data']));
            return $this->errorResponse(__('validationMessages.something_went_wrong'), [
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
