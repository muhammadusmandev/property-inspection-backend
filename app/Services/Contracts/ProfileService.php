<?php

namespace App\Services\Contracts;

use App\Resources\ProfileResource;

interface ProfileService
{
    /**
     * Get profile data
     *
     * @return \Illuminate\Http\JsonResponse|ProfileResource
     * 
     */
    public function getProfileData(): ProfileResource;

    /**
     * Update profile data
     *
     * @param array $data
     * 
     * @return \Illuminate\Http\JsonResponse|ProfileResource
     * 
     */
    public function updateProfileData(array $data): ProfileResource;

    /**
     * delete profile photo
     *
     * @return void
     * 
     */
    public function deleteProfilePhoto(): void;
}