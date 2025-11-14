<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface ReportRepository
{
    public function getAll(): AnonymousResourceCollection;

}
