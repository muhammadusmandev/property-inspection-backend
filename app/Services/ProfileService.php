<?php

namespace App\Services;

use App\Services\Contracts\ProfileService as ProfileServiceContract;
use App\Repositories\Contracts\ForgotPasswordRepository as ForgotPasswordRepositoryContract;
use Intervention\Image\Laravel\Facades\Image;
use \Illuminate\Http\UploadedFile;
use App\Resources\{ ProfileResource };
use Storage;
use DB;

class ProfileService implements ProfileServiceContract
{
    protected $forgotPasswordRepository;

    /**
     * Inject ForgotPasswordRepository via constructor.
     * @param \App\Repositories\Contracts\ForgotPasswordRepositoryContract $forgotPasswordRepository
    */
    public function __construct(ForgotPasswordRepositoryContract $forgotPasswordRepository)
    {
        $this->forgotPasswordRepository = $forgotPasswordRepository;
    }

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

        if (!$user) {
            throw new \Exception('Oops! You are not authenticated');
        }

        $user->bio = $data['bio'];

        if(isset($data['photo'])){
            $photoPath = $this->storeProfilePicture(['user' => $user, 'photo' => $data['photo']]);
            $user->profile_photo = $photoPath;
        }

        $user->update();

        return new ProfileResource($user);
    }

    /**
     * delete profile photo
     *
     * @return void
     * 
     */
    public function deleteProfilePhoto(): void
    {
        $user = auth()->user();

        if (!$user) {
            throw new \Exception('Oops! You are not authenticated');
        }

        $photo = $user->media()->first();

        if ($photo) {
            if ($photo->file_path && Storage::disk('public')->exists($photo->file_path)) {
                Storage::disk('public')->delete($photo->file_path);
            }
            $photo->delete();
        }

        $user->profile_photo = null;
        $user->update();
    }

    /**
     * Reset Password
     *
     * @param array $data
     * 
     * @return void
     * 
     */
    public function resetPassword(array $data): void
    {
        $user = auth()->user();

        if (!$user) {
            throw new \Exception('Oops! You are not authenticated');
        }

        $this->forgotPasswordRepository->attemptResetPassword($user->email, $data['password']);
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
