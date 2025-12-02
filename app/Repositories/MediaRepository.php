<?php

namespace App\Repositories;

use App\Repositories\Contracts\MediaRepository as MediaRepositoryContract;
use App\Models\Media;

class MediaRepository implements MediaRepositoryContract
{
     /**
     * Find media.
     *
     * @param int $id
     * @return \App\Models\Media $media
     */
    public function findById(int $id): Media
    {
        return Media::find($id);
    }
}
