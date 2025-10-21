<?php

namespace App\Services\Contracts;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface CountryService
{
    public function listCountries(): AnonymousResourceCollection;
}
