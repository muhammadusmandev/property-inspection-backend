<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface CountryRepository
{
    public function getAll(): AnonymousResourceCollection;

}
