<?php

namespace App\Services;

use App\Services\Contracts\SettingsService as SettingsServiceContract;
use Intervention\Image\Laravel\Facades\Image;
use \Illuminate\Http\UploadedFile;
use App\Resources\{ ProfileResource };
use Storage;
use DB;

class SettingsService implements SettingsServiceContract
{
    /**
     * Get profile data
     *
     * @return \Illuminate\Http\JsonResponse|ProfileResource
     * 
     */
    public function getProfileData(): ProfileResource
    {
        $user = auth()->user();

        if (!$user) {
            throw new \Exception('Oops! You are not authenticated');
        }

        return new ProfileResource($user);
    }

    /**
     * Update profile data
     *
     * @param array $data
     * 
     * @return \Illuminate\Http\JsonResponse|ProfileResource
     * 
     */
    public function updateProfileData(array $data): ProfileResource
    {
        $user = auth()->user();

        $user->bio = $data['bio'];

        if(isset($data['photo'])){
            $photoPath = $this->storeProfilePicture(['user' => $user, 'photo' => $data['photo']]);
            $user->profile_photo = $photoPath;
        }

        $user->update();

        if (!$user) {
            throw new \Exception('Oops! You are not authenticated');
        }

        return new ProfileResource($user);
    }

    /**
     * Store profile picture.
     *
     * @param array $data
     * @return string
     */
    public function storeProfilePicture(array $data): string
    {
        $user = $data['user'];

        DB::beginTransaction();

        try {
            $file = $data['photo'];

            if ($file instanceof UploadedFile) {
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();

                // create profile image (200x200 max)
                $image = Image::read($file->getRealPath())
                    ->resize(200, 200, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });

                $image_path = 'profile_pictures/' . $filename;

                Storage::disk('public')->put(
                    $image_path,
                    (string) $image->encodeByExtension($file->getClientOriginalExtension(), quality: 90) // 90% quality
                );

                // Delete old media manually
                $oldPhoto = $user->media()->first();
                
                if ($oldPhoto) {
                    if ($oldPhoto->file_path && Storage::disk('public')->exists($oldPhoto->file_path)) {
                        Storage::disk('public')->delete($oldPhoto->file_path);
                    }

                    $oldPhoto->delete();
                }

                $user->media()->create([
                    'file_path' => $image_path,
                    'original_name' => $file->getClientOriginalName(),
                    'type' => $file->getClientMimeType(),
                ]);
            }

            DB::commit();

            return $image_path ?? null;
        } catch (\Exception $e) {
            // Todo: Have to delete profile image from storage if saved
            DB::rollBack();
            throw $e;
        }
    }
}
