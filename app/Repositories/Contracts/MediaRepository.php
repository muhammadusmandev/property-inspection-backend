<?php

namespace App\Repositories\Contracts;

use App\Models\Media;

interface MediaRepository
{
    public function findById(int $id): Media;
}
