<?php

namespace App\Services\Contracts;

interface MediaService
{
    /**
     * Delete media.
     *
     * @param int $id
     * @return void
     */
    public function deleteMedia(int $id): void;

}
