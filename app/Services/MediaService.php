<?php

namespace App\Services;

use App\Services\Contracts\MediaService as MediaServiceContract;
use App\Repositories\Contracts\MediaRepository as MediaRepositoryContract;
use App\Models\Media;
use Illuminate\Auth\Access\AuthorizationException;
use Storage;
use DB;

class MediaService implements MediaServiceContract
{
    protected MediaRepositoryContract $mediaRepository;

    public function __construct(MediaRepositoryContract $mediaRepository)
    {
        $this->mediaRepository = $mediaRepository;
    }

    /**
     * Delete media.
     *
     * @param int $id
     * @return void
     */
    public function deleteMedia(int $id): void
    {
        $media = Media::find($id);  // Todo: Add to repository by findById method

        if (!$media) {
            throw new \Exception('Media not found.');
        }

        // delete file
        if ($media->file_path && Storage::disk('public')->exists($media->file_path)) {
            Storage::disk('public')->delete($media->file_path);
        }

        // delete thumbnail if exist
        if ($media->thumbnail_path && Storage::disk('public')->exists($media->thumbnail_path)) {
            Storage::disk('public')->delete($media->thumbnail_path);
        }

        $media->delete();
    }
}
